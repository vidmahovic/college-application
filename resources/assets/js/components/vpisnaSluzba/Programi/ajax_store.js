export default {
	data: () => ({
		paginate: false,
		filterable: false,
		sortable: false,
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
			type: '',
			is_regular: '',
			page: 1
		},
		apiUrl: '/api/programs'
	}),
	computed: {
		last_page(){
			return this.last_pageData;
		},
		visible_rows(){
			return this.data;
		}
	},
	methods: {
		setPage(page_number, event){
			this.params.page = page_number;

			this.getRows(this.apiUrl, function(){
				this.page = page_number;
			}.bind(this));

			event.target.blur();
		},
		setTable(table){
			this.table = table;
		},
		setData(data){
			this.params.type = data.type;
			this.params.is_regular = data.regular;
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
			this.$http.get(url, {params: this.params})
				.then(function(res){
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
