import ApplicationService from '@/services/ApplicationService'

class PasswordService extends ApplicationService{
  resource = '/auth'

  //* **************************************************** *//

  async forgetPassword (data) {
    return await this.post(`${this.resource}/forget-password`, data)
  }

  async resetPassword (data) {
    return await this.post(`${this.resource}/reset-password`, data)
  }

  //* **************************************************** *//
}
export default new PasswordService
