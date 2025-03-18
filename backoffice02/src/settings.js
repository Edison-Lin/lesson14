module.exports = {

  title: '後台管理系統',

  /**
   * @type {boolean} true | false
   * @description Whether fix the header
   */
  // fixedHeader: false,
  fixedHeader: true,

  /**
   * @type {boolean} true | false
   * @description Whether show the logo in sidebar
   */
  sidebarLogo: true,
  //加入電商平台的設定環境
  ecPlatForm: {
    // db_Url: 'http://front.edu/lesson-14/No_attache/backoffice03/public/getdata/',
    db_Url: '',
    // ec_Url: 'http://front.edu/lesson-14/No_attache/',
    ec_Url: '',
    getIp_Url: '',
    images: 'images',
    productImages: 'product_img',
  },
}
