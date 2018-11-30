const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

//Membros
const Members = () => import('~/pages/members/index').then(m => m.default || m)
const MembersAll = () => import('~/pages/members/membersAll').then(m => m.default || m)
const MembersDetail = () => import('~/pages/members/membersDetail').then(m => m.default || m)

//Calendar
const Calendar = () => import('~/pages/calendar/index').then(m => m.default || m)



const Home = () => import('~/pages/home').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)

export default [
    { path: '/', name: 'welcome', component: Welcome },

    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/password/reset', name: 'password.request', component: PasswordEmail },
    { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

    //Membros
    { path: '/members', component: Members,
        children: [
            { path: '', redirect: { name: 'members.all' } },
            { path: 'all', name: 'members.all', component: MembersAll },
            { path: 'detail', name: 'members.detail', component: MembersDetail },
        ]
    },

    //calendar
    { path: '/calendar', name: 'calendar', component: Calendar },


    { path: '/settings', component: Settings,
        children: [
            { path: '', redirect: { name: 'settings.profile' } },
            { path: 'profile', name: 'settings.profile', component: SettingsProfile },
            { path: 'password', name: 'settings.password', component: SettingsPassword }
        ]
    },

    { path: '/home', name: 'home', component: Home },

    { path: '*', component: NotFound }
]
