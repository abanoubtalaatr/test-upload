import ApplicationService from '@/services/ApplicationService'

class NotificationService extends ApplicationService{
  resource = '/user-notifications'
  //* **************************************************** *//

  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }
  async firstPage () {
    return await this.get(`${this.resource}?page=1&per_page=3`)
  }
  async count () {
    return await this.get(`${this.resource}/count`)
  }
  //* **************************************************** *//
}
export default new NotificationService
