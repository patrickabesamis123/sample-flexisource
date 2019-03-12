const Dashboard = () => import('~/pages/dashboard').then(m => m.default || m);
const Login = () => import('~/pages/auth/login').then(m => m.default || m);
const Register = () => import('~/pages/auth/register').then(m => m.default || m);
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m);
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m);
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m);

export default [
  { path: '/dashboard', name: 'dashboard', component: Dashboard },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '*', component: NotFound },
];
