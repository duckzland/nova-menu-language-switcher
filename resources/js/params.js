export default class Params {
    refreshParams = () => {
        let paramToSearch = [ 'localeParentId', 'locale' ];

        this.params = {};

        paramToSearch.map((pk) => {
            let pv = this.getParams(pk);

            this.params[pk] = pv;
        });
    }

    getParams = (name) => {
        name = name.replace(/[\[\]]/g, '\\$&');
        let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            url = window.location.href,
            results = regex.exec(url);

        if (!results) { 
            return null
        }

        if (!results[2]) {
            return '';
        }

        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }


    appendParamsToAxios = () => {
        let self = this;
        Nova.request().interceptors.request.use((config) => {
            self.refreshParams();

            for (let [pk, pv] of Object.entries(self.params || {})) {
                if (pv) {
                    if (!config.params) {
                        config.params = {};
                    }

                    if (!config.params[pk] || config.params[pk] !== pv) {
                        config.params[pk] = pv;
                    }
                }

                if (config.params && config.params[pk]) {
                    config.headers[pk] = config.params[pk];
                }
                else if (typeof config.headers[pk] !== 'undefined') {
                    delete config.headers[pk];
                }
            }

            return config;
        });
    }
}
