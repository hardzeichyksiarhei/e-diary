const Welcome = () => import('~/pages/welcome')
const Login = () => import('~/pages/auth/login')
const Register = () => import('~/pages/auth/register')
const PasswordEmail = () => import('~/pages/auth/password/email')
const PasswordReset = () => import('~/pages/auth/password/reset')

const Dashboard = () => import('~/pages/dashboard')

const Students = () => import('~/pages/students')
const Staffs = () => import('~/pages/staffs')

const Indicators = () => import('~/pages/indicators')

const Statistics = () => import('~/pages/statistics')
const StatisticsPrimary = () => import('~/pages/statistics/primary')
const StatisticsFunctionalState = () => import('~/pages/statistics/functional-state')
const StatisticsPhysicalFitness = () => import('~/pages/statistics/physical-fitness')
const StatisticsCommonAssessment = () => import('~/pages/statistics/common-assessment')

// const Messages = () => import('~/pages/messages')
// const MessagesInbox = () => import('~/pages/messages/inbox')
// const MessagesStarred = () => import('~/pages/messages/starred')
// const MessagesSent = () => import('~/pages/messages/sent')
// const MessagesCompose = () => import('~/pages/messages/compose')
// const MessagesView = () => import('~/pages/messages/view')
// const MessagesTrash = () => import('~/pages/messages/trash')

const Profile = () => import('~/pages/profile')
const ProfileStaff = () => import('~/pages/profile/staff')
const ProfileStudent = () => import('~/pages/profile/student')

const Files = () => import('~/pages/files')
const ShareFiles = () => import('~/pages/share-files')

const Admin = () => import('~/pages/admin')
const AdminPrimary = () => import('~/pages/admin/primary')
const AdminFaculties = () => import('~/pages/admin/faculties')
const AdminHealthGroups = () => import('~/pages/admin/healthGroups')
const AdminDiseaseGroups = () => import('~/pages/admin/diseaseGroups')
const AdminBulkAdd = () => import('~/pages/admin/bulkAdd')

export default [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  // Teachers Panel
  { path: '/teacher/students', name: 'teacher.students', component: Students, meta: { breadcrumb: 'Студенты' }},

  { path: '/dashboard', name: 'dashboard', component: Dashboard, meta: { breadcrumb: 'Панель управления' }},
  { path: '/indicators', name: 'indicators', component: Indicators, meta: { breadcrumb: 'Измерения и Показатели' }},
  { path: '/statistics', component: Statistics, children: [
    { path: '', name: 'statistics.primary', meta: { breadcrumb: 'Статистическая обработка' }, component: StatisticsPrimary },
    { path: 'functional-state', name: 'statistics.functional-state', component: StatisticsFunctionalState, meta: { breadcrumb: 'Функциональное развитие и состояние (ФР и ФС)' }},
    { path: 'physical-fitness', name: 'statistics.physical-fitness', component: StatisticsPhysicalFitness, meta: { breadcrumb: 'Физическая подготовленность (ФП)' }},
    { path: 'common-assessment', name: 'statistics.common-assessment', component: StatisticsCommonAssessment, meta: { breadcrumb: 'Общая оценка и уровень ФР, ФС и ФП' }}
  ] },
  // { path: '/messages', component: Messages, meta: { breadcrumb: 'Сообщения' }, children: [
  //   { path: '', name: 'messages', redirect: 'inbox' },
  //   { path: 'inbox', name: 'messages.inbox', component: MessagesInbox, meta: { breadcrumb: 'Входящие' }},
  //   { path: 'starred', name: 'messages.starred', component: MessagesStarred, meta: { breadcrumb: 'Помеченные' }},
  //   { path: 'sent', name: 'messages.sent', component: MessagesSent, meta: { breadcrumb: 'Отправленные' }},
  //   { path: 'compose', name: 'messages.compose', component: MessagesCompose, meta: { breadcrumb: 'Написать' }},
  //   { path: 'view/:id', name: 'messages.view', component: MessagesView },
  //   { path: 'trash', name: 'messages.trash', component: MessagesTrash, meta: { breadcrumb: 'Корзина' }}
  // ] },
  { path: '/profile', name: 'profile', component: Profile, meta: { breadcrumb: 'Профайл' }},
  { path: '/profile/staff/:id', name: 'profile.staff', component: ProfileStaff },
  { path: '/profile/student/:id', name: 'profile.student', component: ProfileStudent, meta: { breadcrumb: 'Просмотр профайла' }},
  { path: '/admin', component: Admin, children: [
    { path: '', name: 'admin.primary', component: AdminPrimary, meta: { title: 'Панель админинистратора' }},
    { path: 'staffs', name: 'admin.staffs', component: Staffs, meta: { breadcrumb: 'Сотрудники' }},
    { path: 'students', name: 'admin.students', component: Students, meta: { breadcrumb: 'Студенты' }},
    { path: 'faculties', name: 'admin.faculties', component: AdminFaculties, meta: { breadcrumb: 'Факультеты' }},
    { path: 'health-groups', name: 'admin.health-groups', component: AdminHealthGroups, meta: { breadcrumb: 'Мед. группы здоровья' }},
    { path: 'disease_groups', name: 'admin.disease-groups', component: AdminDiseaseGroups, meta: { breadcrumb: 'Группы заболевания' }},
    { path: 'bulk-add', name: 'admin.bulk-add', component: AdminBulkAdd, meta: { breadcrumb: 'Массовое добавление' }},
  ] },
  { path: '/files', name: 'files', component: Files, meta: { breadcrumb: 'Файлы' }},
  { path: '/files/share', name: 'files.share', component: ShareFiles, meta: { breadcrumb: 'Доступные файлы' }},

  { path: '*', component: require('~/pages/errors/404') }
]
