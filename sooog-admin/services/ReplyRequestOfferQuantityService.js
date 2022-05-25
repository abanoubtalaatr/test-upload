import ApplicationService from "./ApplicationService";

class RequestOfferQuantity extends ApplicationService{
  resource = '/store/request-offer-quantity/reply/list'
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
