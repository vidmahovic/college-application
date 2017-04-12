export default {
	data: () => ({
		page_size: 15
	}),
  methods: {
    setTable(table){
			this.table = table;
		},
    setData(data){
			this.urls = [];
			this.url = data;
			this.urls.push(this.url);
			this.getRows(this.url, function(){
				this.urls.push(this.next_url);
			}.bind(this));
		}
  }
};
