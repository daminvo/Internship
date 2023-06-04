function page(path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'index', component: page('Home.vue') },
  { path: '/login', name: 'login', meta: { title: 'Log In' }, component: page('auth/Login.vue') },
  { path: '/register', name: 'register', meta: { title: 'Register' }, component: page('auth/Register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/ForgotPassword.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/ResetPassword.vue') },

  { path: '/request',  name: 'internship.request', component: page('request') },
  { path: '/apply',  name: 'internship.apply', component: page('apply') },

  { path: '/intern=:internId',  name: 'request.informations', component: page('dashboard/showIntern') },

  { path: '/dashboard', name: 'dashboard', meta: { title: 'Dashboard' }, component: page('dashboard'), },

  { path: '/noteIntern=:internIdTwo', name: 'Marks', meta: { title: 'Marks' }, component: page('marks'), },

  {
    path: '/profile',
    component: page('profile'),
    children: [
      { path: '', redirect: { name: 'profile.info' } },
      { path: 'favorites', name: 'profile.favorites', meta: { title: 'Profile' }, component: page('profile/ProfileFavorites.vue') },
      { path: 'info', name: 'profile.info', meta: { title: 'Profile' }, component: page('profile/ProfileInfo.vue') }
    ]
  },

  { path: '/inbox', name: 'inbox', meta: { title: 'Inbox' }, component: page('Inbox.vue') },
  { path: '/internshipBox', name: 'internshipBox', meta: { title: 'Internship Box' }, component: page('InternshipBox.vue') },
  { path: '/ManagerInternshipBox', name: 'manager.internshipBox', meta: { title: 'Internships Box' }, component: page('InternshipsBoxManager.vue') },

  {
    path: '/profile/edit',
    component: page('editprofile'),
    children: [
      { path: '', redirect: { name: 'editprofile.page' } },
      { path: '/', name: 'editprofile.page', meta: { title: 'Edit Profile' }, component: page('editprofile/EditProfilePage1.vue') },
    ]
  },

  {
    path: '/@/:userId',
    component: page('visit'),
    children: [
      { path: '', redirect: { name: '@.info' } },
      { path: 'internships', name: '@.internships', component: page('visit/VisitInternships.vue') },
      { path: 'favorites', name: '@.favorites', component: page('visit/VisitFavorites.vue') },
      { path: 'info', name: '@.info', component: page('visit/VisitInfo.vue') }
    ]
  },

  { path: '/settings', name: 'settings', meta: { title: 'Settings' }, component: page('settings') },

  { path: '/explore', name: 'explore', meta: { title: 'Explore' }, component: page('Explore.vue') },


  { path: '/offer/post', name: 'offer.post', meta: { title: 'Post Offer' }, component: page('internship/OfferPost.vue') },
  { path: '/offer/:id/edit-post', name: 'project.editpost', meta: { title: 'Edit Project' }, component: page('internship/ProjectEdit.vue') },
  { path: '/offer/:id', name: 'offer.details', meta: { title: 'Offer' }, component: page('internship/OfferDetails.vue') },
  // { path: '/project/:id/review', name: 'project.review', meta: { title: 'Review Project' }, component: page('internship/ProjectReview.vue') },

  {
    path: '/offer/:id/shorlisted',
    component: page('internship/shortlist'),
    name: 'shortlist'
  },

  {
    path: '/offer/:id/apply',
    component: page('internship/apply'),
    children: [
      { path: '', redirect: { name: 'offer.apply' } },
      { path: '/offer/:id/apply', name: 'offer.apply', meta: { title: 'Apply offer' }, component: page('internship/apply/Apply.vue') }
    ]
  },

  { path: '/:url/404', name: '404', meta: { title: 'Error' }, component: page('errors/404.vue') },

  { path: '*', meta: { title: 'Error' }, component: page('errors/404.vue') }
]
