require('./bootstrap');


import { createApp } from 'vue';
import App from './components/App.vue';
import 'ant-design-vue/dist/antd.css';
import Antd from 'ant-design-vue/es';

const app = createApp(App)
app.use(Antd);

app.mount("#app");
