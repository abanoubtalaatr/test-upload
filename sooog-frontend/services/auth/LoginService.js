import ApplicationService from '@/services/ApplicationService'

class LoginService extends ApplicationService{
  resource = '/auth'

  //* **************************************************** *//

  async login (data) {
    return await this.post(`${this.resource}/login`, data)
  }

  async logout (data) {
    return await this.post(`${this.resource}/logout`, data)
  }

  //* **************************************************** *//
}
export default new LoginService
