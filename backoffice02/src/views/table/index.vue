<template>
  <div class="app-container">
    <el-table
      v-loading="listLoading"
      :data="list"
      element-loading-text="Loading"
      border
      fit
      highlight-current-row
    >
      <el-table-column align="center" label="ID" width="95">
        <template slot-scope="scope">
          {{ scope.row.p_id }}
        </template>
      </el-table-column>
      <el-table-column label="Title" width="110">
        <template slot-scope="scope">
          {{ scope.row.p_name }}
        </template>
      </el-table-column>
      <el-table-column label="intro"  align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.p_intro }}</span>
        </template>
      </el-table-column>
      <el-table-column label="price" width="110" align="center">
        <template slot-scope="scope">
          {{ scope.row.p_price }}
        </template>
      </el-table-column>
      <el-table-column class-name="status-col" label="Status" width="110" align="center">
        <template slot-scope="scope">
          <el-tag :type="scope.row.status | statusFilter">{{ scope.row.status }}</el-tag>
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="Display_time" width="200">
        <template slot-scope="scope">
          <i class="el-icon-time" /><br>
          <span>{{ scope.row.p_date }}</span>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { getList } from '@/api/table'

export default {
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'gray',
        deleted: 'danger'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      list: null,
      listLoading: true
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      this.listLoading = true
      getList()
      .then(response => {
        this.list = response.data
        console.log(this.list);
        this.listLoading = false
      }).catch(response=>{
        alert(response.data);
      })
    }
  }
}
</script>
