import objectPath from 'object-path';

export default {
	data: () => ({
		paginate: false,
		filterable: false,
		sortable: true,
		can_resize: false,
		filter: '',
		sort_by: '',
		sort_dir: 'asc',
		page: 1,
		page_size: 30,
		last_pageData: 1,
		data: [],
		table: null,
		params: {
			program_id: '',
      nationality_id: '',
			faculty_id: ''
		},
		apiUrl: '/api/applications/paginate'
	}),
	computed: {
		last_page(){
			return this.last_pageData;
		},
		visible_rows(){
			return this.sorted_rows;
		},
		filtered_rows(){
			var rows = this.data;

			if(this.filterable && this.filter){
				var filter_words = this.filter.split(' ');

				return rows.filter(function(row){

					for(var f in filter_words){
						var filter_word = filter_words[f];

						if(typeof filter_word.toLowerCase === 'function'){
							filter_word = filter_word.toLowerCase();
						}

						var pass = false;

						for(var i in this.table.columns){
							var column_definition = this.table.column_props[i];
							var column_text = '';

							if(!column_definition.filterable){
								continue;
							}

							if(column_definition.field){
								column_text = objectPath.get(row, column_definition.field);
							}else if(typeof column_definition.callback === 'function'){
								column_text = (column_definition.callback)(row);
							}else{
								continue;
							}

							if(!column_text){
								continue;
							}

							column_text = ('' + column_text + '').trim();

							if(typeof column_text.toLowerCase === 'function'){
								column_text = column_text.toLowerCase();
							}

							if(column_text.indexOf(filter_word) !== -1){
								var pass = true;
							}
						}

						if(!pass){
							return false;
						}
					}

					return true;
				}, this);
			}

			return rows.filter(function(row){return true;});
		},
		sorted_rows(){
			var column = this.table.column_props[this.sort_by];

			if(!column || this.sort_by === null){
				return this.filtered_rows;
			}

			return this.filtered_rows.sort(function(a,b){
				var value_a = column.callback ? column.callback(a) : objectPath.get(a, column.field);
				var value_b = column.callback ? column.callback(b) : objectPath.get(b, column.field);

				if(value_a == value_b){
					return 0;
				}

				var sort_val = value_a > value_b ? 1 : -1;

				if(this.sort_dir === 'dsc'){
					sort_val *= -1;
				}

				return sort_val;
			}.bind(this));
		}
	},
	methods: {
		sortBy(column_id){
			if(this.sort_by === column_id){
				switch(this.sort_dir){
					case null:
						this.sort_dir = 'asc';
						break;
					case 'asc':
						this.sort_dir = 'dsc';
						break;
					case 'dsc':
						this.sort_dir = null;
						break;
				}

				return;
			}

			this.sort_by = column_id;
			this.sort_dir = 'asc';
		},
		setPage(page_number, event){
			this.page = page_number;

			this.getRows(this.apiUrl, function(){
				this.page = page_number;
			}.bind(this));

			event.target.blur();
		},
		setTable(table){
			this.table = table;
		},
		setData(data){
      this.params.program_id = data.programData.id;
      this.params.nationality_id = data.regular;
			this.params.faculty_id = data.facultyData.id;
			this.getRows(this.apiUrl);
		},
		setFilterable(value){
			this.filterable = value;
		},
		setPaginate(value){
			this.paginate = value;
		},
		setSortable(value){
			this.sortable = value;
		},
		getRows(url, callback){
			this.$http.get(url, {params: {filters: this.params, page: this.page}})
				.then(function(res){
          console.log(res.data);
					this.data = res.data.data;
					this.page_size = res.data.meta.pagination.per_page;
					this.last_pageData = res.data.meta.pagination.total_pages;
					if(callback) callback();

				}.bind(this));
		}
	},
	watch: {
		filter(){
			this.page = 1;
		},
		page_size(){
			this.page = 1;
		}
	}
}
