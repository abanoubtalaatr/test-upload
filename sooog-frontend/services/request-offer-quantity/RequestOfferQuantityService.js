import ApplicationService from '@/services/ApplicationService'

class RequestOfferQuantity extends ApplicationService{
    resource = '/request-offer-quantity'
    //* **************************************************** *//
    async getAll (queryParam = {}) {
        return await this.get(`${this.resource}${queryParam}`)
    }

    async create (data) {
        return await this.post(`${this.resource}`, data)
    }
    //* **************************************************** *//
}
export default new RequestOfferQuantity
