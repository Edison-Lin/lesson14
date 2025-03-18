
import request from '@/utils/request';   //連結AXIOS遠端呼叫函數
import defaultSettings from '@/settings' //連結平台環境設定參
const db_Url = defaultSettings.ecPlatForm.db_Url; //取出電商平台資料庫網址
// 取得資料庫的carousel每一頁的內容，table=carousel那個表格/{page}讀那一頁/{limit}每頁筆數限制
export const reqCarouselList = (page, limit) => {
    return request({ url: `${db_Url}reqTable.php?page=${page}&table=carousel&limit=${limit}`, method: 'GET' })
};

//carousel廣告上/下架後端資料庫服務
export const reqCarouselOnline = (cFields) => {
    let toDBstr="caro_id="+cFields.caro_id+
                "&caro_online="+cFields.caro_online+
                "&mode=caro_Online";                //carousel廣告上/下架模式
    return request({ url: `${db_Url}reqTableAccess.php`, method: 'POST', data: toDBstr });
};
//建立carousel廣告輪播的資料刪除
export const reqCarouselDel = (cFields) => {
    let toDBstr="caro_id="+cFields.caro_id+
                "&mode=caro_Delete";                //carousel廣告輪播的資料刪除模式
    return request({ url: `${db_Url}reqTableAccess.php`, method: 'POST', data: toDBstr });
};

//建立carousel廣告輪播的資料新增與修改
export const reqCarouselAccess = (cFields) => {
    // debugger;
    if (cFields.caro_id) {
        let toDBstr="caro_title="+cFields.caro_title+
                "&caro_content="+cFields.caro_content+
                "&caro_online="+cFields.caro_online+
                "&caro_sort="+cFields.caro_sort+
                "&p_id="+cFields.p_id+
                "&caro_pic="+cFields.caro_pic+
                "&caro_id="+cFields.caro_id+
                "&mode=caro_Update";                //carousel廣告輪播的資料修改模式
        return request({ url: `${db_Url}reqTableAccess.php`, method: 'POST', data: toDBstr });
    } else {
        let toDBstr="caro_title="+cFields.caro_title+
                "&caro_content="+cFields.caro_content+
                "&caro_online="+cFields.caro_online+
                "&caro_sort="+cFields.caro_sort+
                "&p_id="+cFields.p_id+
                "&caro_pic="+cFields.caro_pic+
                "&mode=caro_Append";               // carousel廣告輪播的資料新增模式
        return request({ url: `${db_Url}reqTableAccess.php`, method: 'POST', data:toDBstr});
        // return request({ url: `${db_Url}reqTableAccess.php`, method: 'POST', data:tempvar});
    }
};
