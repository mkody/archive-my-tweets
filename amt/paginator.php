<?php

namespace AMWhalen\ArchiveMyTweets;

class Paginator {

    /**
     * Returns the HTML to display pagination links.
     *
     * @param string $urlTemplate The URL template for links with a page number.
     * @param int $total The total number of items across all pages.
     * @param int $currentPage The current page to be displayed.
     * @param int $perPage The total tweets per page.
     * @return string The pagination links HTML.
     */
    public function paginate($baseUrl, $total, $currentPage=1, $perPage=100, $niceUrl=true) {

        if ($total == 0) {
            return '';
        }

        $numPages = ceil($total / $perPage);

        $pageMarker = ($niceUrl) ? 'page/' : '&page=';

        $html = '<nav><ul class="pagination justify-content-center">';

        if ($currentPage > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . $pageMarker . ($currentPage - 1) . '" tabindex="-1">Newer Tweets</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
	}

        $html .= '<li class="page-item disabled"><span class="page-link">Page ' . $currentPage . ' of ' . $numPages . '<span></li>';

        if ($currentPage < $numPages) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . $pageMarker . ($currentPage + 1) . '">Older Tweets</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Older Tweets</span></li>';
	}

        $html .= '</ul></nav>';

        return $html;

    }

}
