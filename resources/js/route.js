import Dashboard from './components/Dashboard.vue';
import ListAppointment from './components/Pages/Appointment/list_appointment.vue';

export default [
    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard,
    },
    {
        path: '/admin/appointment',
        name: 'admin.appointment',
        component: ListAppointment,
    }
]