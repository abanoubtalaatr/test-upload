import ApplicationService from '@/services/ApplicationService'

class CategoryService extends ApplicationService{
  resource = '/categories'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async getSubcategories (id) {
    return await this.get(`${this.resource}/${id}/sub-categories`)
  }

  //* **************************************************** *//
}
export default new CategoryService
