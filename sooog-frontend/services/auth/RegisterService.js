import ApplicationService from '@/services/ApplicationService'

class RegisterService extends ApplicationService{
  resource = '/auth'

  //* **************************************************** *//

  async register (data) {
    return await this.post(`${this.resource}/register`, data)
  }

  async resendCode (data) {
    return await this.post(`${this.resource}/resend-verification-code`, data)
  }

  async activateRegisterCode (data) {
    return await this.post(`${this.resource}/verify-account`, data)
  }

  async verifyPasswordCode (data) {
    return await this.post(`${this.resource}/verify-token`, data)
  }

  //* **************************************************** *//
}
export default new RegisterService
