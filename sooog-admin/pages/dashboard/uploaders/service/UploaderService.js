import ApplicationService from '@/services/ApplicationService'

class UploaderService extends ApplicationService{
  resource = '/admin'

  //* **************************************************** *//
  async uploadSingleFile (data) {
    const formData = new FormData()
    formData.append('path', data.path)
    formData.append('file', data.file)
    if (data.width && data.height) {
      formData.append('width', data.width)
      formData.append('height', data.height)
    }
    return await this.post(`${this.resource}/uploader`, formData)
  }

  async uploadMultipleFiles (data) {
    const formData = new FormData()
    Array.from(data.files).forEach(function (file, index) {
      formData.append('files[' + index + ']', file)
    })
    formData.append('path', data.path)
    if (data.width && data.height) {
      formData.append('width', data.width)
      formData.append('height', data.height)
    }

    return await this.post(`${this.resource}/uploader/multiple-files`, formData)
  }

  async deleteSingleFile (data) {
    const formData = new FormData()
    formData.append('path', data.path)
    formData.append('file', data.file)

    return await this.post(`${this.resource}/uploader/delete`, formData)
  }

  //* **************************************************** *//
}
export default new UploaderService
