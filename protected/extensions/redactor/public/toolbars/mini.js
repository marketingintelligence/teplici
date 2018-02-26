var RTOOLBAR = {
	styles:
	{ 
		title: RLANG.styles,
		func: 'show', 				
		dropdown: 
	    {
			 p:
			 {
			 	title: RLANG.paragraph,			 
			 	exec: 'formatblock',
			 	param: '<p>'
			 },
			 blockquote:
			 {
			 	title: RLANG.quote,
			 	exec: 'formatblock',	
			 	param: '<blockquote>'
			 },
			 pre:
			 {  
			 	title: RLANG.code,
			 	exec: 'formatblock',
			 	param: '<pre>',
			 	style: 'font-family: monospace, sans-serif;'
			 },
			 h2:
			 {
			 	title: RLANG.header1,			 
			 	exec: 'formatblock',   
			 	param: '<h2>'
			 },
			 h3:
			 {
			 	title: RLANG.header2,			 
			 	exec: 'formatblock', 
			 	param: '<h3>'
			 }																
		},
		separator: true
	},
	bold:
	{
		title: RLANG.bold,
		exec: 'bold'
	}, 
	italic: 
	{
		title: RLANG.italic,
		exec: 'italic',
		separator: true		
	},
	insertunorderedlist:
	{
		title: '&bull; ' + RLANG.unorderedlist,
		exec: 'insertunorderedlist'
	},
	insertorderedlist: 
	{
		title: '1. ' + RLANG.orderedlist,
		exec: 'insertorderedlist'
	},
	outdent: 
	{	
		title: '< ' + RLANG.outdent,
		exec: 'outdent'
	},
	indent:
	{
		title: '> ' + RLANG.indent,
		exec: 'indent',
		separator: true
	},
	link:
	{ 
		title: RLANG.link, 
		func: 'show', 				
		dropdown: 
		{
			link: 	{name: 'link', title: RLANG.link_insert, func: 'showLink'},
			unlink: {exec: 'unlink', name: 'unlink', title: RLANG.unlink}
		}															
	},
	image:
	{
		title: RLANG.image, 						
		func: 'showImage' 			
	},
	video:
	{
		title: RLANG.video,
		func: 'showVideo'
	}
};