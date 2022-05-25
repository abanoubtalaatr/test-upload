import ApplicationService from '@/services/ApplicationService'

class ProductService extends ApplicationService{
  resource = '/store/products'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async listCategoryProperties(category_id) {
    return await this.get(`store/category-properties/${category_id}`)
  }

  async getSubCategories(category_id) {
    return await this.get(`store/subcategories?is_paginated=0&type=stores&category=${category_id}`)
  }

  async create (data) {
    return await this.post(`${this.resource}`, data)
  }

  async update (data, id) {
    return await this.put(`${this.resource}/${id}`, data)
  }

  async toggleStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}/toggle-status`, data)
  }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async destroy (id) {
    return await this.delete(`${this.resource}/${id}`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/exports${queryParam}`, {}, {responseType: 'arraybuffer'})
  }
  //* **************************************************** *//
}
export default new ProductService
