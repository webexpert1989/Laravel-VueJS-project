import Vue from 'vue'
import Router from 'vue-router'
// Containers
import Full from '../containers/Full'
// Views
// Views / Apps
import Apps from '../views/apps/Apps'
import Feeds from '../views/apps/Feeds'
import FeedItems from '../views/apps/FeedItems'

// Views / Apps / Crud
import AppCrud from '../views/apps/crud/AppCrud'
import FeedCrud from '../views/apps/crud/FeedCrud'
import FeedItemCrud from '../views/apps/crud/FeedItemCrud'

// Views / Users
import Profile from '../views/users/Profile'
import Users from '../views/users/Users'

Vue.use(Router)

export default new Router({
  mode: 'hash',
  linkActiveClass: 'open active',
  scrollBehavior: () => ({y: 0}),
  routes: [
    {
      path: '/',
      redirect: '/apps',
      name: 'Home',
      component: Full,
      children: [
        {
          path: 'apps',
          name: 'Apps',
          component: Apps
        },
        {
          path: 'app/:id',
          name: 'App Edit',
          component: AppCrud
        },
        {
          path: 'apps/create',
          name: 'Create App',
          component: AppCrud
        },

        {
          path: 'feedsrcs',
          name: 'Feeds',
          component: Feeds
        },
        {
          path: 'feedsrcs/create',
          name: 'Feed Source Create',
          component: FeedCrud
        },
        {
          path: 'feed/:id',
          name: 'Feed Source Edit',
          component: FeedCrud
        },
        {
          path: 'feeditems',
          name: 'Feed Items',
          component: FeedItems
        },
        {
          path: 'feeditem/:id',
          name: 'Feed Item Edit',
          component: FeedItemCrud
        },
        {
          path: 'profile',
          name: 'My Profile',
          component: Profile
        },
        {
          path: 'users',
          name: 'Users',
          component: Users
        },
      ]
    }
  ]
})
