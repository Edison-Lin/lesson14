import request from '@/utils/request'

// 取得資料庫的表格每一頁的內容，含table=carousel那個表格/{page}讀那一頁/{limit}每頁筆數限制，包含keyWord
export const reqProductList = (page, limit,table,keyWord) => {
  return request({ url: `reqTable.php?page=${page}&table=${table}&limit=${limit}&keyWord=${keyWord}`, method: 'GET' })
};

export function getList(params) {
  return request({
    url: 'product.php',
    method: 'get',
    params
  })
}
