<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
		<script src="https://unpkg.com/element-ui/lib/index.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.3"></script>
	</head>
	<body>
		<div id="app">
			<el-table :data="animaux">
				<el-table-column label="ID" prop="animal_id"></el-table-column>
				<el-table-column label="Nom" prop="nom"></el-table-column>
				<el-table-column label="Couleur"  prop="couleur"></el-table-column>
				<el-table-column label="Sexe" prop="sexe"></el-table-column>
			</el-table>
			<el-pagination
				layout="prev, pager, next"
				@current-change="handleCurrentPageChange"
				:current-page.sync="page"
				:page-size="42"
				:total="total">
			</el-pagination>
			<el-select v-model="pageSize" placeholder="Nombre de résultats" @change="getAnimaux(page)">
				<el-option label="42" value="42"></el-option>
				<el-option label="100" value="100"></el-option>
				<el-option label="200" value="200"></el-option>
			</el-select>
		</div>

		<script>
		  const { createApp } = Vue

		  var app = new Vue({
		  	el: '#app',
		    data() {
		      return {
		        animaux: [],
		        total: 0,
		        page: 1,
		        pageSize: 42
		      }
		    },
		    mounted() {
		    	this.getAnimaux(this.page);
		    },
		    methods: {
		    	async getAnimaux(page) {
		    		try {
		    			const animauxResponse = await this.$http.get('./animal.php?page=' + page + '&pageSize=' + this.pageSize);
		    			this.animaux = animauxResponse.body.items;
		    			this.total = parseInt(animauxResponse.body.total, 10);
		    		} catch (e) {
		    			this.$message({
				          	message: `La requête a échoué ${e.message}`,
				          	type: 'danger'
				        });
		    		}
		    	},
		    	async handleCurrentPageChange(page) {
	    			await this.getAnimaux(page);
		    	}
		    }
		  });
		</script>
	</body>
</html>