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


  {
    path: '/profile',
    component: page('profile'),
    children: [
      { path: '', redirect: { name: 'profile.projects' } },
      { path: 'projects', name: 'profile.projects', meta: { title: 'Profile' }, component: page('profile/ProfileProjects.vue') },
      { path: 'wishlists', name: 'profile.wishlist', meta: { title: 'Profile' }, component: page('profile/ProfileWishlist.vue') },
      { path: 'info', name: 'profile.info', meta: { title: 'Profile' }, component: page('profile/ProfileInfo.vue') }
    ]
  },

  { path: '/inbox', name: 'inbox', meta: { title: 'Inbox' }, component: page('Inbox.vue') },
  { path: '/internshipBox', name: 'internshipBox', meta: { title: 'Internship Box' }, component: page('InternshipBox.vue') },

  {
    path: '/newcomer',
    component: page('auth/newcomer'),
    children: [
      { path: '', redirect: { name: 'newcomer.page1' } },
      { path: '1', name: 'newcomer.page1', component: page('auth/newcomer/NewcomerPage1.vue') },
      { path: '2', name: 'newcomer.page2', component: page('auth/newcomer/NewcomerPage2.vue') },
      { path: '3', name: 'newcomer.page3', component: page('auth/newcomer/NewcomerPage3.vue') }
    ]
  },

  {
    path: '/profile/edit',
    component: page('editprofile'),
    children: [
      { path: '', redirect: { name: 'editprofile.page1' } },
      { path: 'page1', name: 'editprofile.page1', meta: { title: 'Edit Profile' }, component: page('editprofile/EditProfilePage1.vue') },
      { path: 'page2', name: 'editprofile.page2', meta: { title: 'Edit Profile' }, component: page('editprofile/EditProfilePage2.vue') }
    ]
  },

  {
    path: '/@/:tagname',
    component: page('visit'),
    children: [
      { path: '', redirect: { name: '@.info' } },
      { path: 'projects', name: '@.projects', component: page('visit/VisitProjects.vue') },
      { path: 'wishlists', name: '@.wishlist', component: page('visit/VisitWishlist.vue') },
      { path: 'info', name: '@.info', component: page('visit/VisitInfo.vue') }
    ]
  },

  { path: '/@/:tagname/message', name: 'message', component: page('Message.vue') },

  { path: '/settings', name: 'settings', meta: { title: 'Settings' }, component: page('settings') },

  { path: '/explore', name: 'explore', meta: { title: 'Explore' }, component: page('Explore.vue') },

  { path: '/offer/post', name: 'offer.post', meta: { title: 'Post Offer' }, component: page('internship/OfferPost.vue') },
  { path: '/project/:id/edit-post', name: 'project.editpost', meta: { title: 'Edit Project' }, component: page('internship/ProjectEdit.vue') },
  { path: '/project/:id', name: 'project.details', meta: { title: 'Project' }, component: page('internship/ProjectDetails.vue') },
  { path: '/project/:id/review', name: 'project.review', meta: { title: 'Review Project' }, component: page('internship/ProjectReview.vue') },
  { path: '/project/:id/dashboard', name: 'project.dashboard', meta: { title: 'Project' }, component: page('internship/dashboard') },

  {
    path: '/project/:id/shorlisted',
    component: page('project/shortlist'),
    children: [
      { path: '', redirect: { name: 'shortlist.individual' } },
      { path: '/project/:id/shorlisted/individual', name: 'shortlist.individual', meta: { title: 'Apply Project' }, component: page('internship/shortlist/ShortlistIndividual.vue') },
      { path: '/project/:id/shorlisted/team', name: 'shortlist.team', meta: { title: 'Apply Project' }, component: page('internship/shortlist/ShortlistTeam.vue') }
    ]
  },

  { path: '/:url/404', name: '404', meta: { title: 'Error' }, component: page('errors/404.vue') },

  { path: '*', meta: { title: 'Error' }, component: page('errors/404.vue') }
]
