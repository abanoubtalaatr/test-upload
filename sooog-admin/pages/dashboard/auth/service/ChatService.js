import ApplicationService from '@/services/ApplicationService'

class ChatService extends ApplicationService{
  resource = '/admin/chats'

  //* **************************************************** *//

  async getAll () {
    return await this.get(`${this.resource}`)
  }

  async firstPage () {
    return await this.get(`${this.resource}?page=1&per_page=3`)
  }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async sendMessage (data) {
    return await this.post(`${this.resource}`, data)
  }

  //* **************************************************** *//
}
export default new ChatService
