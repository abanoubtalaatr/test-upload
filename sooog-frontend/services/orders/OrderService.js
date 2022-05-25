import ApplicationService from '@/services/ApplicationService'

class OrderService extends ApplicationService{
  resource = '/orders'
  //* **************************************************** *//

  async getAll (queryParam = {}) {
    return await this.get(`/orders${queryParam}`)
  }

  async allMethods () {
    return await this.get(`/payment-methods`)
  }

  async allOnlineMethods () {
    return await this.get(`/online-payment-methods`)
  }

  async allBanks () {
    return await this.get(`/bank-accounts`)
  }

  async serviceCheckout (data) {
    return await this.post(`/orders/service`, data)
  }

  async checkout (data) {
    return await this.post(`/orders`, data)
  }

  async previewOrder (data) {
    return await this.post(`/orders/preview`, data)
  }

  async changeStatus (data, id) {
    return await this.put(`/orders/${id}/change-status`, data)
  }

  async refundOrder (id, data) {
    return await this.post(`/orders/${id}/refund`, data)
  }

  //* **************************************************** *//
}
export default new OrderService
