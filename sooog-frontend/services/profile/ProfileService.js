import ApplicationService from '@/services/ApplicationService'

class ProfileService extends ApplicationService{
  resource = '/auth'

  //* **************************************************** *//

  async updateProfile (data) {
    return await this.put(`/profile`, data)
  }

  async getTransactions (queryParam = {}) {
    return await this.get(`/user-transactions${queryParam}`)
  }

  async updatePassword (data) {
    return await this.post(`/profile/change-password`, data)
  }

  async verifyUpdatedPhone (data) {
    return await this.post(`/profile/verify-phone`, data)
  }

  //* **************************************************** *//
}
export default new ProfileService
