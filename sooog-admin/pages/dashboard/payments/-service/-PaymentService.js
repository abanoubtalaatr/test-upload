import ApplicationService from '@/services/ApplicationService'

class PaymentService extends ApplicationService{
  resource = '/admin/payments'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async show (id) {
    return await this.get(`/admin/payments/${id}`)
  }

  async pdfExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-pdf`)
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-excel${queryParam}`, {}, {responseType: 'arraybuffer'})
  }

  //* **************************************************** *//
}
export default new PaymentService
