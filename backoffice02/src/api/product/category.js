import request from '@/utils/request';      //連結AXIOS遠端呼叫函數
import defaultSettings from '@/settings';   //連結平台環境設定參
const db_Url = defaultSettings.ecPlatForm.db_Url; //取出電商平台資料庫網址
const ec_Url = defaultSettings.ecPlatForm.ec_Url; //取出電商平台資料庫網址
const productImages= defaultSettings.ecPlatForm.productImages; //取出平台產品圖片目錄

//產品上/下架p_open欄位資料更新後端服務
export const reqProductOnline=(product)=>{
    // debugger;
    let toDBstr="p_id="+product.p_id+
    "&p_open="+product.p_open+
    "&mode=p_Open_Update";       //p_open資料更新模式
    return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
}

//產品詳細規格p_content欄位資料更新後端服務
export const reqP_Content=(product)=>{
    let toDBstr="p_id="+product.p_id+
    "&p_content="+encodeURIComponent(product.p_content)+
    "&mode=P_Content_Update";       //p_content資料更新模式
    return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
}
//產品進行刪除處理，先刪除資料表product,product_img資料
export const reqProductDel=(row)=>{
    let toPOSTstr=`mode=ProductDel&p_id=${row.p_id}`;
    return request({ url: `${db_Url}reqTable_double.php`, method: 'POST',data:toPOSTstr});
};
//產品更新，圖檔新增上傳處理，將檔名新增到product_img資料表
export const reqInsertProductImg=async (mode, fileName,p_id,sort)=>{
    let toPOSTstr=`mode=${mode}&fileName=${fileName}&p_id=${p_id}&sort=${sort}`;
    let result=await request({ url: `${db_Url}reqTableAccess.php`, method: 'POST',data:toPOSTstr});
    if(result==200){
        return true;
    }else {
        return false;
    }
};
//產品更新圖檔進行刪除處理，先刪除資料表product_img資料
export const reqProduct_Img_Del_Db=(mode, fileName,p_id)=>{
    let toPOSTstr=`mode=${mode}&fileName=${fileName}&p_id=${p_id}`;
    return request({ url: `${db_Url}reqTable_double.php`, method: 'POST',data:toPOSTstr});
};

export const reqRemoveImages=(picFileList)=>{
    let tempstr="";
    for(let i=0;i<picFileList.length;i++){
        tempstr=tempstr+"&picFileList["+i+"]="+picFileList[i].name;
    }
    let toPOSTstr="mode=removeImages"+tempstr+`&sFolder=${productImages}`;
    //新增取消後圖檔進行刪除處理
    return request({ url: `${ec_Url}file_control.php`, method: 'POST',data:toPOSTstr });
};
//產品的新增資料與更新資料兩種模式
export const reqProductAccess=(product)=>{
    if (product.p_id) {
        let toDBstr="p_id="+product.p_id+
                "&classid="+product.classid+
                "&p_name="+product.p_name+
                "&p_intro="+product.p_intro+
                "&p_price="+product.p_price+
                "&p_open="+product.p_open+
                "&mode=product_Update";       //資料更新模式
        return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
    } else {
        let tempstr="";
        for(let i=0;i<product.picFileList.length;i++){
            tempstr=tempstr+"&img_file["+i+"]="+product.picFileList[i].name;
        }
        let toDBstr="classid="+product.classid+
                "&p_name="+product.p_name+
                "&p_intro="+product.p_intro+
                "&p_price="+product.p_price+
                "&p_open="+product.p_open+tempstr+
                "&mode=product_Append";               //資料新增模式
        return request({ url: `${db_Url}reqTable_double.php`, method: 'POST', data:toDBstr});
    }
};
export const reqFileControl = (mode, fileName) => {
    //圖檔上傳後，放棄進行刪除處理
    let toPOSTstr=`mode=${mode}&fileName=${fileName}&sFolder=${productImages}`;
    return request({ url: `${ec_Url}file_control.php`, method: 'POST',data:toPOSTstr });
};
export const reqProductList01 = (page, limit,table,keyWord,classId02) => {
    //呼叫後端資料庫，取回產品的分頁資料，表格為：product
    return request({ url: `${db_Url}reqTable.php?page=${page}&table=${table}&limit=${limit}&keyWord=${keyWord}&classid=${classId02}`, method: 'GET' });
};
export const reqPyclass01=()=>{
    //取得分類第一層目錄
    // debugger;  
    return request({ url: `${db_Url}reqTableAll.php?mode=pyclass01`, method: 'GET' });
};
export const reqPyclass02=(classid01)=>{
    //取得分類第二層目錄
    // debugger;  
    return request({ url: `${db_Url}reqTableAll.php?mode=pyclass02&classid=${classid01}`, method: 'GET' });
};
