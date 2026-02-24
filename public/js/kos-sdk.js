// Mock SDK for localStorage - KosConnect
window.dataSdk = {
    init: async (handler) => {
        window.dataHandler = handler;
        // Load data from localStorage
        const stored = localStorage.getItem('kosconnect_data');
        const data = stored ? JSON.parse(stored) : [];
        if (window.dataHandler) {
            window.dataHandler.onDataChanged(data);
        }
        return { isOk: true };
    },
    create: async (item) => {
        try {
            const stored = localStorage.getItem('kosconnect_data');
            const data = stored ? JSON.parse(stored) : [];
            const newItem = { ...item, __backendId: Date.now().toString() + Math.random().toString(36).substr(2, 9) };
            data.push(newItem);
            localStorage.setItem('kosconnect_data', JSON.stringify(data));
            if (window.dataHandler) {
                window.dataHandler.onDataChanged(data);
            }
            return { isOk: true };
        } catch (e) {
            return { isOk: false };
        }
    },
    update: async (item) => {
        try {
            const stored = localStorage.getItem('kosconnect_data');
            const data = stored ? JSON.parse(stored) : [];
            const index = data.findIndex(d => d.__backendId === item.__backendId);
            if (index !== -1) {
                data[index] = item;
                localStorage.setItem('kosconnect_data', JSON.stringify(data));
                if (window.dataHandler) {
                    window.dataHandler.onDataChanged(data);
                }
            }
            return { isOk: true };
        } catch (e) {
            return { isOk: false };
        }
    },
    delete: async (item) => {
        try {
            const stored = localStorage.getItem('kosconnect_data');
            const data = stored ? JSON.parse(stored) : [];
            const filtered = data.filter(d => d.__backendId !== item.__backendId);
            localStorage.setItem('kosconnect_data', JSON.stringify(filtered));
            if (window.dataHandler) {
                window.dataHandler.onDataChanged(filtered);
            }
            return { isOk: true };
        } catch (e) {
            return { isOk: false };
        }
    }
};

window.elementSdk = {
    init: async (config) => {
        window.elementConfig = config;
        // Load config from localStorage
        const stored = localStorage.getItem('kosconnect_config');
        const savedConfig = stored ? JSON.parse(stored) : {};
        const mergedConfig = { ...config.defaultConfig, ...savedConfig };
        if (config.onConfigChange) {
            config.onConfigChange(mergedConfig);
        }
        return { isOk: true };
    },
    setConfig: async (newConfig) => {
        const stored = localStorage.getItem('kosconnect_config');
        const currentConfig = stored ? JSON.parse(stored) : {};
        const updatedConfig = { ...currentConfig, ...newConfig };
        localStorage.setItem('kosconnect_config', JSON.stringify(updatedConfig));
        if (window.elementConfig && window.elementConfig.onConfigChange) {
            window.elementConfig.onConfigChange(updatedConfig);
        }
        return { isOk: true };
    }
};
