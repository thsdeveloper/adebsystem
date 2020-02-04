const Welcome = () => import('~/pages/welcome').then(m => m.default || m);

const Login = () => import('~/pages/auth/login').then(m => m.default || m);
const Register = () => import('~/pages/auth/register').then(m => m.default || m);
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m);
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m);
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m);
const NotPermision = () => import('~/pages/errors/notPermission').then(m => m.default || m);


//Dashboard
const Home = () => import('~/pages/home').then(m => m.default || m);

//Membros
const Members = () => import('~/pages/members/index').then(m => m.default || m);
const MembersAll = () => import('~/pages/members/membersAll').then(m => m.default || m);
const MembersDetail = () => import('~/pages/members/membersDetail').then(m => m.default || m);
const MembersEditar = () => import('~/pages/members/memberEditar').then(m => m.default || m);
const MembersCreated = () => import('~/pages/members/membersCreated').then(m => m.default || m);

//Setores / Igrejas
const HomeSetoresIgreja = () => import('~/pages/setoresIgrejas/index').then(m => m.default || m);
const SetoresIgreja = () => import('~/pages/setoresIgrejas/setores-igrejas').then(m => m.default || m);
const CadastrarIgreja = () => import('~/pages/setoresIgrejas/cadastrar-igreja').then(m => m.default || m);
const VisualizarIgreja = () => import('~/pages/setoresIgrejas/visualizar-igreja').then(m => m.default || m);


//Secretaria
const Secretaria = () => import('~/pages/secretaria/index').then(m => m.default || m);
const SecretariaHome = () => import('~/pages/secretaria/home').then(m => m.default || m);
const SecretariaVisitantes = () => import('~/pages/secretaria/visitantes').then(m => m.default || m);
const SecretariaCartaRecomendacao = () => import('~/pages/secretaria/cartaRecomendacao').then(m => m.default || m);

//Financeiro
const Financeiro = () => import('~/pages/financeiro/index').then(m => m.default || m);
const FinanceiroHome = () => import('~/pages/financeiro/home').then(m => m.default || m);
const FinanceiroCadastrarReceita = () => import('~/pages/financeiro/cadastrarReceita').then(m => m.default || m);
const FinanceiroCadastrarDespesa = () => import('~/pages/financeiro/cadastrarDespesa').then(m => m.default || m);



//Calendar
const Calendar = () => import('~/pages/calendar/index').then(m => m.default || m);


const Settings = () => import('~/pages/settings/index').then(m => m.default || m);
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m);
const SettingsAcessos = () => import('~/pages/settings/acessos').then(m => m.default || m);
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m);

export default [
  {path: '/', name: 'welcome', component: Login},

  {path: '/login', name: 'login', component: Login},
  {path: '/register', name: 'register', component: Register},
  {path: '/password/reset', name: 'password.request', component: PasswordEmail},
  {path: '/password/reset/:token', name: 'password.reset', component: PasswordReset},

  //Secretaria
  {
    path: '/secretaria', name: 'secretaria', component: Secretaria,
    children: [
      {path: '', redirect: {name: 'secretaria.home'}},
      {path: 'home', name: 'secretaria.home', component: SecretariaHome},
      {path: 'visitantes', name: 'secretaria.visitantes', component: SecretariaVisitantes},
      {path: 'cartaRecomendacao', name: 'secretaria.cartaRecomendacao', component: SecretariaCartaRecomendacao},
    ]
  },

  //Secretaria
  {
    path: '/financeiro', name: 'financeiro', component: Financeiro,
    children: [
      {path: '', redirect: {name: 'financeiro.home'}},
      {path: 'home', name: 'financeiro.home', component: FinanceiroHome},
      {path: 'cadastrar-receita', name: 'financeiro.cadastrarReceita', component: FinanceiroCadastrarReceita},
      {path: 'cadastrar-despesa', name: 'financeiro.cadastrarDespesa', component: FinanceiroCadastrarDespesa},
    ]
  },

  //Setores / Igrejas
  {
    path: '/setoresIgrejas', component: HomeSetoresIgreja,
    children: [
      {path: '', redirect: {name: 'setoresIgrejas.home'}},
      {path: 'home', name: 'setoresIgrejas.home', component: SetoresIgreja},
      {path: 'cadastrar-igreja', name: 'cadastrar.igreja', component: CadastrarIgreja},
      {path: 'visualizar-igreja/:id', name: 'visualizar.igreja', component: VisualizarIgreja},
    ]
  },


  //Membros
  {
    path: '/members', component: Members,
    children: [
      {path: '', redirect: {name: 'members.all'}},
      {path: 'all', name: 'members.all', component: MembersAll},
      {path: 'detail/:id', name: 'members.detail', component: MembersDetail, props: true},
      {path: 'editar/:id', name: 'members.editar', component: MembersEditar, props: true},
      {path: 'created', name: 'members.created', component: MembersCreated},
    ]
  },

  //calendar
  {path: '/calendar', name: 'calendar', component: Calendar},


  {
    path: '/settings', component: Settings,
    children: [
      {path: '', redirect: {name: 'settings.profile'}},
      {path: 'profile', name: 'settings.profile', component: SettingsProfile},
      {path: 'acessos', name: 'configuracoes.acessos', component: SettingsAcessos},
      {path: 'password', name: 'settings.password', component: SettingsPassword}
    ]
  },

  {path: '/home', name: 'home', component: Home},

  {path: '*', component: NotFound},
  {path: '*', name: 'not_permission', component: NotPermision}
]
