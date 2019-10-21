<template>
  <v-row>
    <v-col md="4" v-for="(item, i) in files" :key="i">
      <v-card :color="(item.success === true) ? 'light-green accent-4' : 'primary'" dark :loading="item.active">
        <v-img :src="item.thumb" class="white--text" height="200px" gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)">
          <v-card-title class="fill-height align-end" v-text="item.name"></v-card-title>
          <v-list-item-subtitle v-text="item.type+' | '+ item.size"></v-list-item-subtitle>
        </v-img>

        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn icon @click.prevent="$refs.upload.remove(item)">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <v-row>
      <v-col md="12">
        <div class="example-btn">
          <file-upload
            class="btn btn-primary"
            post-action="/api/upload/files"
            extensions="gif,jpg,jpeg,png,webp,pdf"
            accept="image/png,image/gif,image/jpeg,image/webp,application/pdf"
            :multiple="true"
            :size="1024 * 1024 * 10"
            :value="files"
            :maximum="10"
            @input-filter="inputFilter"
            @input="inputUpdate"
            ref="upload">
            <v-btn color="primary">Procurar arquivos</v-btn>
          </file-upload>

          <v-btn color="primary" v-if="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.active = true">
            Upload
          </v-btn>

          <v-btn color="red" v-else @click.prevent="$refs.upload.active = false">Cancelar</v-btn>
        </div>
      </v-col>
    </v-row>
  </v-row>
</template>
<style>
  .example-vuex label.btn {
    margin-bottom: 0;
    margin-right: 1rem;
  }
</style>

<script>
    import {mapGetters} from 'vuex'
    import FileUpload from 'vue-upload-component'

    export default {
        components: {
            FileUpload,
        },
        data: () => ({
            name: 'file',
        }),
        computed: {
            ...mapGetters({
                files: 'upload/files',
            }),
        },
        methods: {
            inputFilter(newFile, oldFile, prevent) {
                if (newFile && !oldFile) {
                    // Before adding a file
                    // 添加文件前
                    // Filter system files or hide files
                    // 过滤系统文件 和隐藏文件
                    if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
                        return prevent()
                    }
                    // Filter php html js file
                    // 过滤 php html js 文件
                    if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
                        return prevent()
                    }
                    // Automatic compression
                    // 自动压缩
                    if (newFile.file && newFile.type.substr(0, 6) === 'image/' && this.autoCompress > 0 && this.autoCompress < newFile.size) {
                        newFile.error = 'compressing'
                        const imageCompressor = new ImageCompressor(null, {
                            convertSize: Infinity,
                            maxWidth: 512,
                            maxHeight: 512,
                        })
                        imageCompressor.compress(newFile.file)
                            .then((file) => {
                                this.$refs.upload.update(newFile, {error: '', file, size: file.size, type: file.type})
                            })
                            .catch((err) => {
                                this.$refs.upload.update(newFile, {error: err.message || 'compress'})
                            })
                    }
                }
                if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
                    // Create a blob field
                    // 创建 blob 字段
                    newFile.blob = ''
                    let URL = window.URL || window.webkitURL
                    if (URL && URL.createObjectURL) {
                        newFile.blob = URL.createObjectURL(newFile.file)
                    }
                    // Thumbnails
                    // 缩略图
                    newFile.thumb = ''
                    if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
                        newFile.thumb = newFile.blob
                    }
                }
            },
            inputUpdate(files) {
                this.$store.dispatch('upload/updateFiles', files);
            },
        }
    }
</script>
