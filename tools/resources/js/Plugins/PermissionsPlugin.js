import { provide } from "vue";

export default {
    install: (app, options) => {
        function can(routeString) {
            var permissions = app.config.globalProperties.$page.props.appPermissions;
            routeString = routeString.replace(/^\.+|\.+$/g, '');

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
