import ApplicationService from '@/services/ApplicationService'

class UploaderService extends ApplicationService{
  //* **************************************************** *//
  async uploadSingleFile (data) {
    const formData = new FormData()
    formData.append('path', data.path)
    formData.append('file', data.file)
    if (data.width) {
      formData.append('width', data.width)
      formData.append('height', data.height)
    }
    return await this.post(`/uploader`, formData)
  }

  async deleteSingleFile (data) {
    const formData = new FormData()
    formData.append('path', data.path)
    formData.append('file', data.file)

    return await this.post(`/uploader/delete`, formData)
  }
  //* **************************************************** *//
}
//** Singleton Service **//
const UploaderRestService = new UploaderService()

export default UploaderRestService
