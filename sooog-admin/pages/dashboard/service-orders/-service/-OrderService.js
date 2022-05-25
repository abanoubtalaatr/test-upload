import ApplicationService from '@/services/ApplicationService'

class OrderService extends ApplicationService{
  resource = '/admin/orders'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async filterOrders (data) {
    return await this.get(`${this.resource}`, {params: data})
  }

  async listPaymentMethods () {
    return await this.get('/admin/payment-methods')
  }

  async listStatuses () {
    return await this.get('/admin/statuses')
  }

  async update (data, id) {
    return await this.put(`${this.resource}/service/${id}`, data)
  }

  async changeStatus (id, data = {}) {
    return await this.put(`${this.resource}/${id}/change-status`, data)
  }

  async show (id) {
    return await this.get(`${this.resource}/${id}`)
  }

  async destroy (id) {
    return await this.delete(`${this.resource}/${id}`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-excel${queryParam}`, {}, {responseType: 'arraybuffer'})
  }

  async refund (data, id) {
    return await this.post(`${this.resource}/${id}/refund`, data)
  }
  //* **************************************************** *//
}
export default new OrderService
