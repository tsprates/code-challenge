import { createApp } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router'
import App from './App.vue'
import AddPurchase from './components/AddPurchase.vue'
import Balance from './components/Balance.vue'
import DepositCheck from './components/DepositCheck.vue'
import Expenses from './components/Expenses.vue'
import Incomes from './components/Incomes.vue'
import Login from './components/Login.vue'
import NotFound from './components/NotFound.vue'
import SignUp from './components/SignUp.vue'
import './style.css'

const routes = [
    { path: '/login', component: Login, name: 'login' },
    { path: '/signup', component: SignUp, name: 'signUp' },
    { path: '/', redirect: '/login' },
    { path: '/balance', component: Balance, name: 'balance' },
    { path: '/incomes', component: Incomes, name: 'incomes' },
    { path: '/expenses', component: Expenses, name: 'expenses' },
    { path: '/expenses/add', component: AddPurchase, name: 'addPurchase' },
    { path: '/incomes/add', component: DepositCheck, name: 'depositCheck' },
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
]

const router = createRouter({
    history: createWebHashHistory(),
    routes,
})

const app = createApp(App)

app.use(router)

app.mount('#app')
