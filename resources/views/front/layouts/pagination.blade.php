<?php if(isset($pageInfo) && $pageInfo['pageCount'] >= $pageInfo['pageNo'] && $pageInfo['pageCount'] > 1) {  ?>
    <div class="pagination-style text-center pt-40 ">
    <ul class="pagination">

    </ul>
    <script>
        $(function() {
            $('.pagination').pagination({
                items: '<?= $pageInfo['totalCount'] ?>',
                itemsOnPage: '<?=$pageInfo['perPageSize']?>',
                currentPage: '<?= $pageInfo['pageNo'] ?>',
                edges: 2,
                displayedPages: 5,
                cssStyle: 'my-paginataion',
                hrefTextPrefix: '<?= $pageInfo['pageUrl'] ?>?page=',
                hrefTextSuffix: '&<?= $pageInfo['subfixStr']?>',
                prevText: '<i class="la la-angle-left"></i>',
                nextText: '<i class="la la-angle-right"></i>',
                onPageClick: function (pageNumber, event) {
                    
                },
                onInit: function() {
                    
                }
            });
        });
    </script>
    </div>    
<?php } ?>
