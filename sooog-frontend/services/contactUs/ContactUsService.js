import ApplicationService from '@/services/ApplicationService'

class ContactUsService extends ApplicationService{
  resource = '/contact-us'
  //* **************************************************** *//

  async create (data) {
    return await this.post(`${this.resource}`, data)
  }
  //* **************************************************** *//
}
export default new ContactUsService
