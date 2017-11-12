export const APP_ENV = process.env.MIX_APP_ENV;
export const APP_URL = process.env.MIX_APP_URL;
export const SHOW_ERROR_TIME = 10; // error message will be removed after X seconds

export var profile = {
    first_name: '',
    last_name: '',
    email: ''
};

export var admin = {
	admin_id: '',
	profile
};

export var manager = {
	manager_id: '',
	profile
};

export var regular = {
	regular_id: '',
	profile
};