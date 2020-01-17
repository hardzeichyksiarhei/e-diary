export const Storage = {
    methods: {
        storageGet(name) {
            if (typeof (Storage) !== 'undefined') {
                return window.localStorage.getItem(name)
            } else {
                window.alert('Please use a modern browser to properly view this template!')
            }
        },

        storageSave(name, val) {
            if (typeof (Storage) !== 'undefined') {
                window.localStorage.setItem(name, val)
            } else {
                window.alert('Please use a modern browser to properly view this template!')
            }
        }
    }
}