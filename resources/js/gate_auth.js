export default class GateAuth {

	constructor(user) {
		this.user = user;
	}

	isSuperAdmin() {
		return this.user.type === 'super_admin';
	}

	isAdmin() {
		return this.user.type === 'admin';
	}

	isRegistrar() {
		return this.user.type === 'registrar';
	}

	isCashier() {
		return this.user.type === 'casher';
	}

	isSuperAdminOrAdmin() {
		if(this.user.type === 'super_admin' || this.user.type === 'admin') {
			return true;
		}
	}

}