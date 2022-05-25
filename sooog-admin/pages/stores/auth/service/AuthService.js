import ApplicationService from '@/services/ApplicationService'

class AuthService extends ApplicationService{
  resource = '/store/auth'

  //* **************************************************** *//

  async login (data) {
    return await this.post(`${this.resource}/login`, data)
  }

  async logout () {
    return await this.post(`${this.resource}/logout`)
  }

  async updateProfile (data) {
    return await this.put(`${this.resource}/profile`, data)
  }

  async updateBankData (data) {
    return await this.put(`${this.resource}/profile/bank-setting`, data)
  }

  async getProfile (id) {
    return await this.get(`${this.resource}/profile/${id}`)
  }

  async forgetPassword (data) {
    return await this.post(`${this.resource}/forget-password?type=stores`, data)
  }

  async resetPassword (data) {
    return await this.post(`${this.resource}/reset-password`, data)
  }

  async updatePassword (data) {
    return await this.put(`${this.resource}/profile/change-password`, data)
  }

  //* **************************************************** *//
}
export default new AuthService
