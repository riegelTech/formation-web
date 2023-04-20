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
				<el-table-column label="Opérations">
				  <template slot-scope="scope">
					<el-button size="mini" @click="editAnimal(scope.$index, scope.row)">Editer</el-button>
					<el-button size="mini" type="danger" @click="deleteAnimal(scope.$index, scope.row)">Supprimer</el-button>
				  </template>
				</el-table-column>
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
			<el-dialog title="Fiche animal" v-loading="animalForm.loading" :visible.sync="animalForm.display">
				<el-form>
					<el-form-item label="Nom">
						<el-input v-model="animalForm.animal.nom"></el-input>
					</el-form-item>
					<el-form-item label="Sexe">
						<el-select v-model="animalForm.animal.sexe" placeholder="Select">
							<el-option label="Femelle" value="Femelle"></el-option>
							<el-option label="Mâle" value="Mâle"></el-option>
						</el-select>
					</el-form-item>
					<el-form-item label="Stérilisé">
						<el-switch
							v-model="animalForm.animal.sterelise"
							active-text="Oui"
							inactive-text="Non">
						</el-switch>
					</el-form-item>
					<el-form-item label="Activité">
						<el-select v-model="animalForm.animal.activite" placeholder="Select">
							<el-option label="Calme" value="Calme"></el-option>
							<el-option label="Activité normale" value="Activité normale"></el-option>
							<el-option label="Sportif" value="Sportif"></el-option>
						</el-select>
					</el-form-item>
					<el-form-item label="Date de naissance">
						<el-date-picker v-model="animalForm.animal.date_naissance" type="date" placeholder="Choississez un jour" value-format="yyyy-MM-dd HH:mm:ss"></el-date-picker>
					</el-form-item>
					<el-form-item>
						<el-button type="primary" @click="saveAnimal">Enregistrer</el-button>
						<el-button @click="closeAnimalForm">Annuler</el-button>
					</el-form-item>
				</el-form>
			</el-dialog>
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
				pageSize: 42,
				animalForm: {
					display: false,
					loading: true,
					animal: {}
				}
			  }
			},
			mounted() {
				this.getAnimaux();
			},
			methods: {
				async getAnimaux() {
					try {
						const animauxResponse = await this.$http.get('./animals/?page=' + this.page + '&pageSize=' + this.pageSize);
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
					this.page = page;
					await this.getAnimaux();
				},
				async editAnimal(index, animal) {
					this.animalForm.display = true;
					this.animalForm.loading = true;
					try {
						const animalResponse = await this.$http.get(`./animals/?animal_id=${animal.animal_id}`);
						this.animalForm.animal = animalResponse.body;
						this.animalForm.animal.sterelise = this.animalForm.animal.sterelise === '1' ? true : false;

					} catch (e) {
						this.animalForm.display = false;
						this.$message({
						  	message: `La requête a échoué ${e.body || e.message}`,
						  	type: 'danger'
						});
					}
					this.animalForm.loading = false;
				},
				closeAnimalForm() {
					this.animalForm.animal = {};
					this.animalForm.display = false;
				},
				async saveAnimal() {
					this.animalForm.display = true;
					this.animalForm.loading = true;
					try {
						this.animalForm.animal.sterelise = this.animalForm.animal.sterelise === false ? 0 : 1;
						const animalResponse = await this.$http.put(`./animals/?animal_id=${this.animalForm.animal.animal_id}`, this.animalForm.animal);

					} catch (e) {
						this.$message({
						  	message: `La requête a échoué ${e.body || e.message}`,
						  	type: 'danger'
						});
					}
					this.closeAnimalForm();
					this.animalForm.loading = false;
					this.getAnimaux();
				},
				async deleteAnimal(index, animal) {
					try {
						await this.$confirm('Ceci effacera la fiche animal, continuer ?', 'Attention', {
		                    confirmButtonText: 'OK',
		                    cancelButtonText: 'Annuler',
		                    type: 'warning'
		                });
		                await this.doDeleteAnimal(animal.animal_id)
					} catch (e) {
						this.$message({
		                    type: e === 'cancel' ? 'info' : 'error',
		                    message: e === 'cancel' ? 'Suppression annulée' : e.body
		                });
					}
				},
				async doDeleteAnimal(animalId) {
					try {
						const animalResponse = await this.$http.delete(`./animals/?animal_id=${animalId}`);
						this.getAnimaux();
					} catch (e) {
						this.$message({
						  	message: `La requête a échoué ${e.body || e.message}`,
						  	type: 'danger'
						});
					}
				}
			}
		  });
		</script>
	</body>
</html>