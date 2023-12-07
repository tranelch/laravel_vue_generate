import { provide } from "vue";

export default {
    install: (app, options) => {
        function can(routeString) {
            //var action = /[^.]*$/.exec(routeString)[0];
            var permissions = app.config.globalProperties.$page.props.appPermissions;
            //return ['*', action, routeString].some(value => permissions.indexOf(value) >= 0)

            return permissions.filter(
                (permission) =>
                    permission.startsWith(routeString) &&
                    (routeString.slice(-1) === '.' || permission.length === routeString.length)
            ).length > 0
        }

        app.config.globalProperties.$can = can;
        app.provide("permissions", {can});
    }
};
