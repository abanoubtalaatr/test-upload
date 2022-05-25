import ApplicationService from '@/services/ApplicationService'

class PackageService extends ApplicationService{
    resource = '/packages'
    //* **************************************************** *//
    async getAll (queryParam = {}) {
        return await this.get(`${this.resource}${queryParam}`)
    }

    //* **************************************************** *//
}
export default new PackageService
