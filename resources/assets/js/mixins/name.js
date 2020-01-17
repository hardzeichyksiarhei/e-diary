export const FullName = {
    filters: {
        full_name(user) {
            if (!user) return '';
            let { first_name, last_name, patronymic_name } = user;
            let res = last_name + ' ' + first_name;
            if (patronymic_name.length) res += ' ' + patronymic_name;
            return res;
        }
    }
}

export const FullNameShort = {
    filters: {
        full_name_short(user) {
            if (!user) return '';
            let { first_name, last_name, patronymic_name } = user;
            let res = last_name + ' ' + first_name;
            if (patronymic_name.length) {
                res = last_name + ' ' + first_name[0] + '. ' + patronymic_name[0] + '.';
            }
            return res;
        }
    }
}