import ApplicationService from '@/services/ApplicationService'

class FinancialDuesService extends ApplicationService{
  resource = '/admin/financial-dues'
  //* **************************************************** *//
  async getAll (queryParam = {}) {
    return await this.get(`${this.resource}${queryParam}`)
  }

  async payment (data) {
    return await this.post(`/admin/payments`, data)
  }

  async pdfExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-pdf${queryParam}`, {}, {responseType: 'arraybuffer'})
  }

  async excelExport (queryParam = {}) {
    return await this.get(`${this.resource}/export-to-excel${queryParam}`, {}, {responseType: 'arraybuffer'})
  }

  //* **************************************************** *//
}
export default new FinancialDuesService
