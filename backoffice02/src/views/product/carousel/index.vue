<template>
  <div>
    <h3>Carousel首頁廣告輪播管理</h3>
    <hr />
    <el-button
      type="primary"
      round
      icon="el-icon-circle-plus-outline"
      @click="appendCaro">新增</el-button
    >
    <!-- element-ui使用table表格元件 -->
    <el-table style="width: 100%; margin-top: 1%" border :data="list">
      <el-table-column prop="caro_id" label="編號" width="35" align="center">
      </el-table-column>
      <el-table-column prop="caro_title" label="輪播標題" width="180">
      </el-table-column>
      <el-table-column prop="caro_content" label="內容介紹"> </el-table-column>
      <el-table-column prop="caro_online" label="上/下架" width="150">
        <template slot-scope="{ row }">
          <el-switch
            v-model="row.caro_online"
            active-color="#13ce66"
            inactive-color="#ff4949"
            active-text="上架"
            inactive-text="下架"
            :active-value="1"
            :inactive-value="0"
            @change="updateOnline(row)"
          >
          </el-switch>
        </template>
      </el-table-column>
      <el-table-column prop="caro_sort" label="輪播排序" width="35">
      </el-table-column>
      <el-table-column prop="caro_pic" label="圖檔名稱">
        <template slot-scope="{ row }">
          <img
            :src="`${imageUrl}${row.caro_pic}`"
            v-bind:alt="row.caro_title"
            style="width: 100%; height: auto"
            v-bind:title="row.caro_pic"
          />
        </template>
      </el-table-column>
      <el-table-column prop="p_id" label="對映產品名稱(編號)">
        <template slot-scope="{ row }">
          <span v-bind:title="row.p_name"
            >{{ row.p_name }}({{ row.p_id }})</span
          >
        </template>
      </el-table-column>
      <el-table-column
        prop="create_date"
        label="建立日期"
        width="100"
      ></el-table-column>
      <el-table-column prop="prop" label="操作" align="center" width="100">
        <template slot-scope="{ row }">
          <el-button
            type="warning"
            plain
            icon="el-icon-edit"
            size="mini"
            @click="updateCaro(row)" 
            style="display:block;margin:0px auto;"
            >修改</el-button
          >
          <el-button
            type="danger"
            plain
            icon="el-icon-delete"
            size="mini"
            @click="deleteCaro(row)"
            style="display:block;margin:0px auto;"
            >刪除</el-button
          >
        </template>
      </el-table-column>
    </el-table>
    <!-- 分頁器的函數呼叫 
      @size-change="handleSizeChange"         // 設定分頁的筆數
      @current-change="handleCurrentChange"   // 換頁呼叫函數
    -->
    <el-pagination
      style="margin-top: 20px; text-align: center"
      :current-page="page"
      :page-sizes="[3, 5, 10]"
      :page-size="limit"
      :total="total"
      @current-change="getPageList"
      @size-change="handleSizeChange"
      layout="prev, pager, next, jumper,->, sizes,total"
    >
    </el-pagination>
    <!-- 修改與新增對話框 -->
    <el-dialog title="Carousel編輯頁" :visible.sync="dialogFormVisible">
      <el-form
        style="width: 90%"
        :model="cFields"
        :rules="rules"
        ref="ruleForm"
      >
        <el-form-item
          label="輪播標題:"
          :label-width="formLabelWidth"
          prop="caro_title"
        >
          <el-input autocomplete="off" v-model="cFields.caro_title"></el-input>
        </el-form-item>
        <el-form-item
          label="內容介紹:"
          :label-width="formLabelWidth"
          prop="caro_content"
        >
          <el-input
            autocomplete="off"
            v-model="cFields.caro_content"
          ></el-input>
        </el-form-item>
        <el-form-item label="上/下架:" :label-width="formLabelWidth">
          <el-switch
            active-color="#13ce66"
            inactive-color="#ff4949"
            active-text="上架"
            inactive-text="下架"
            :active-value="1"
            :inactive-value="0"
            v-model="cFields.caro_online"
          >
          </el-switch>
        </el-form-item>
        <el-form-item
          label="輪播排序:"
          :label-width="formLabelWidth"
          prop="caro_sort"
        >
          <el-input autocomplete="off" v-model="cFields.caro_sort"></el-input>
        </el-form-item>
        <el-form-item
          label="對映產品編號:"
          :label-width="formLabelWidth"
          prop="p_id"
        >
          <el-input autocomplete="off" v-model="cFields.p_id" :disabled="true">
            <el-button slot="append" @click="choiceP_id"
              >選擇產品編號</el-button
            >
          </el-input>
        </el-form-item>
        <el-form-item
          label="上傳輪播圖片:"
          :label-width="formLabelWidth"
          prop="caro_pic"
        >
          <el-upload
            class="avatar-uploader"
            :action="upload_UrlFile"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload"
            :data="sPath"
          >
            <img
              v-if="cFields.caro_pic"
              :src="`${imageUrl}${cFields.caro_pic}`"
              class="avatar"
              :title="`${imageUrl}${cFields.caro_pic}`"
            />
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            <div slot="tip" class="el-upload__tip">
              只能上傳jpg/png格式，並且不可超過500KB
            </div>
          </el-upload>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="carouselAccess">{{
          cFields.caro_id ? "更 新" : "新 增"
        }}</el-button>
      </div>
    </el-dialog>
    <el-dialog
      width="60%"
      title="選擇carousel對映的產品"
      :visible.sync="innerVisible"
      append-to-body
      :close-on-click-modal="false"
    >
      <el-row>
        <el-col :span="8">
          <el-input
            v-model="formInline.keyWord"
            placeholder="產品編號或名稱關鍵字查詢"
          ></el-input>
        </el-col>
        <el-col :span="4"
          ><el-button type="primary" @click="onSearch">查詢</el-button></el-col>
      </el-row>
      <hr />
      <el-table :data="productList" border style="width: 100%">
        <el-table-column prop="prop" label="選擇帶回產品編號" align="center" width="100">
          <template slot-scope="{ row }">
            <el-button type="success" icon="el-icon-check" circle plain size="mini" @click="selectP_id(row)" ></el-button>
          </template>
        </el-table-column>
        <el-table-column prop="p_id" label="產品編號" width="100" align="center">
        </el-table-column>
        <el-table-column prop="img_file" label="圖片" width="100" align="center">
          <template slot-scope="{ row }">
          <img :src="`${imageUrl}${row.img_file}`" v-bind:alt="row.p_name" style="width: 100%; height: auto" v-bind:title="row.p_name" />
        </template>
        </el-table-column>
        <el-table-column prop="p_name" label="名稱" min-width="100">
        </el-table-column>
        <el-table-column prop="p_price" label="價格" width="80" align="center">
        </el-table-column>
      </el-table>
      <el-pagination
      style="margin-top: 20px; text-align: center"
      :current-page="productPage"
      :page-sizes="[3, 5, 10]"
      :page-size="productLimit"
      :total="productTotal"
      @current-change="getProductList"
      @size-change="productSizeChange"
      layout="prev, pager, next, jumper,->, sizes,total">
      </el-pagination>
    </el-dialog>
  </div>
</template>
<script>
export default {
  name: "carousel",
  data() {
    return {
      page: 1, //目前的第幾頁
      limit: 3, //預設的每頁筆數
      total: 0, //資料的總筆數
      list: [], //資料存放的陣列
      dialogFormVisible: false, //編輯對話框開啟或隱藏
      formLabelWidth: "20%", //輸入LABEL的寬度
      imageUrl: "", //上傳圖片至電商前台專屬圖片放置完整的URL路徑
      upload_UrlFile: "", //電商前台上傳的執行PHP路徑
      // sPath:{"sFolder":"product_img"},
      //上傳圖片至伺服器的目錄
      sPath: { sFolder: "" },
      cFields: {
        //carousel表單欄位資料存放位置
        caro_id: "",
        caro_title: "",
        caro_content: "",
        caro_online: "1",
        caro_sort: "",
        p_id: "",
        caro_pic: "",
      },
      rules: {
        caro_title: [
          { required: true, message: "需輸入標題文字", trigger: "blur" },
        ],
        caro_content: [
          { required: true, message: "需輸入說明文字", trigger: "blur" },
        ],
        caro_sort: [
          { required: true, message: "需輸入排序數字", trigger: "blur" },
          {
            type: "integer",
            message: "需輸入數字",
            trigger: "blur",
            transform: Number,
          },
        ],
        p_id: [
          { required: true, message: "需選擇對應的產品編號", trigger: "blur" },
          {
            type: "integer",
            message: "需輸入數字",
            trigger: "blur",
            transform: Number,
          },
        ],
        caro_pic: [{ required: true, message: "需上傳成功的圖檔" }],
      },
      innerVisible: false, //控制選擇p_id內層對話框顯示的開關
      formInline: { keyWord: "" }, //產品查詢關鍵字
      productList:[],   //產品product存放陣列
      productPage: 1,   //產品product目前的第幾頁
      productLimit: 3,  //產品product預設的每頁筆數
      productTotal: 0,  //產品product資料的總筆數
      buttons:this.$store.state.user.person.buttons,    //取得vuex功能權限按鈕資料
    };
  },

  mounted() {
    //取得上傳圖片路徑：'product_img',;
    this.sPath.sFolder = this.$store.state.settings.ecPlatForm.productImages;

    //上傳圖片至電商前台專屬圖片放置完整的URL路徑'http://front.edu/lesson-14/No_attache/product_img'
    this.imageUrl =
      this.$store.state.settings.ecPlatForm.ec_Url + this.sPath.sFolder + "/";

    //上傳電商前台的PHP程式執行URL路徑+檔名'http://front.edu/lesson-14/No_attache/file_upload_parser01.php'
    this.upload_UrlFile =
      this.$store.state.settings.ecPlatForm.db_Url + "file_upload_parser01.php";
    // this.buttons=this.$store.state.user.person.buttons;
    this.getPageList();
  },
  methods: {
    async updateOnline(row){
      // debugger;
      let result = await this.$API.carousel.reqCarouselOnline(row);
          if (result.code == 200) {
            this.$message({
              type: "success",
              message: "更新成功!",
            });
          }
    },
    selectP_id(row){
      this.innerVisible=false;
      this.cFields.p_id=row.p_id;   //將產品P_id帶回上層
    },
    //product資料查詢函數
    onSearch() {
      this.getProductList();
    },
    choiceP_id() {
      //開啟P_ID產品選擇對話框
      this.innerVisible = true;
      //取得產品product相關資料
      this.getProductList(this.productPage);
    },
    carouselAccess() {
      this.$refs.ruleForm.validate(async (valid) => {
        if (valid) {
          this.dialogFormVisible = false;
          let result = await this.$API.carousel.reqCarouselAccess(this.cFields);
          if (result.code == 200) {
            this.$message({
              showClose: true,
              message: result.message,
              type: "success",
            });
            //TABLE重新讀取資料，若為為更新模式，TABLE頁面需停在目前編輯頁，若為新增模式TABLE為第一頁
            this.getPageList(this.cFields.caro_id ? this.page : 1);
          }
        } else {
          return false;
        }
      });
    },
    async getPageList(pager = 1) {
      this.page = pager;
      const { page, limit } = this;
      let result = await this.$API.carousel.reqCarouselList(page, limit);
      if (result.code == 200) {
        //取得回傳的總筆數與列表資料
        this.total = result.data.total;
        this.list = result.data.records;
      }
    },
    //取得product的資料存在productList中
    async getProductList(pager = 1) {
      this.productPage = pager;
      const { productPage, productLimit } = this;
      let result = await this.$API.table.reqProductList(
        productPage,
        productLimit,
        "product",
        this.formInline.keyWord
      );
      if (result.code == 200) {
        this.productTotal = result.data.total;
        this.productList = result.data.records;
      }
    },
    //若單頁限制的筆數調整，則重新讀取product
    productSizeChange(limit) {
      this.productLimit = limit;
      this.getProductList();
    },
    handleSizeChange(limit) {
      this.limit = limit;
      this.getPageList();
    },
    //新增一筆carousel
    appendCaro() {
      this.dialogFormVisible = true;
      //清除表單之前的資料
      this.cFields = {
        caro_id: "",
        caro_title: "",
        caro_content: "",
        caro_online: "1",
        caro_sort: "",
        p_id: "",
        caro_pic: "",
      };
    },
    //修改單筆的carousel，並接收row傳入的單筆資料
    updateCaro(row) {
      this.dialogFormVisible = true;
      this.cFields = { ...row }; //將資料使用複製方式，接入各欄位顯示，並給使用者修改
    },
    //刪除單筆的資料
    deleteCaro(row) {
      //跳出對話框，確認是否要刪除
      this.$confirm(`你確定是否刪除：${row.caro_title}？`, "是否刪除？", {
        confirmButtonText: "確定",
        cancelButtonText: "取消",
        type: "warning",
      })
        .then(async () => {
          let result = await this.$API.carousel.reqCarouselDel(row);
          if (result.code == 200) {
            this.$message({
              type: "success",
              message: "删除成功!",
            });
            //this.list.length>1?this.page:this.page-1，預設每頁3筆，若刪完等於0筆時，向前跳一頁
            this.getPageList(this.list.length > 1 ? this.page : this.page - 1);
          }
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消删除",
          });
        });
    },
    //上傳成功後的處理
    handleAvatarSuccess(res, file) {
      // debugger;
      // console.log(this.$store.state.settings);
      if (res.success == "true") {
        this.cFields.caro_pic = res.fileName;
      } else {
        alert(res.error);
      }
    },
    //上傳之前的圖檔格式與檔案大小判斷
    beforeAvatarUpload(file) {
      const isImg =
        "image/jpeg,image/svg+xml,image/gif,image/png,image/webp".includes(
          file.type
        );
      const isLt2M = file.size / 1024 / 1024 < 2;
      if (!isImg) {
        this.$message.error("上傳文件不符合圖片格式！");
      }
      if (!isLt2M) {
        this.$message.error("上传头像图片大小不能超过 2MB!");
      }
      return isImg && isLt2M;
    },
  },
};
</script>

<style>
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 100%;
  height: auto;
  /* height: 178px; */
  display: block;
}
</style>