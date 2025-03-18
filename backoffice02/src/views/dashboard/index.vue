<template>
  <div class="dashboard-container">
    <div class="dashboard-text">
      管理者登入資訊
      <hr>
      <p>登入帳號：{{ name }}</p>
      <p>管理者email：{{ person.ademail }}</p>
      <p>管理者ID：{{ person.adid }}</p>
      <p>管理者姓名：{{ person.adname }}</p>
      <p>管理者頭像：{{ person.avatar }}<img :src="'images/avatar/'+person.avatar" style="width: 5%;" /></p>
      <p>管理者群組：{{ person.gpname }}</p>
      <p>最後登入時間：{{ person.lastlogin }}</p>
      <p>最後登入IP：{{ person.sip }}</p>
      <p>取得伺服器token：{{ person.token }}</p>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Dashboard',
  computed: {
    ...mapGetters([
      'name',
      "person"
    ])
  }
}
</script>

<style lang="scss" scoped>
.dashboard {
  &-container {
    margin: 30px;
  }
  &-text {
    font-size: 30px;
    line-height: 46px;
  }
}
</style>
