jQuery('#quiz_score_report_table').DataTable({
  dom: 'Pfrtip',
  columnDefs:[
    {
      searchPanes:{
        show: true,
      },
      targets: [0],
    },
    {
      searchPanes:{
        show: false,
      },
      targets: [1,2,3,4,5],
    }
  ]
});
