<?php

namespace Start\Controller;

use App\Model\FragmentQuery;
use Perfumer\Framework\Controller\ViewController;
use Perfumer\Framework\View\StatusView;
use Perfumer\Framework\View\StatusViewControllerHelpers;
use Propel\Runtime\ActiveQuery\Criteria;

class FragmentsController extends ViewController
{
    use StatusViewControllerHelpers;

    public function get()
    {
        $fragments = FragmentQuery::create()
            ->joinWith('User')
            ->filterByUser($this->getUser())
            ->filterByClosedAt(null, Criteria::ISNULL)
            ->orderByCreatedAt(Criteria::DESC)
            ->find();

        $content = [];

        foreach ($fragments as $fragment) {
            $content[] = [
                'id' => $fragment->getId(),
                'name' => $fragment->getUser()->getUsername(),
                'title' => $fragment->getTitle()
            ];
        }

        $this->setContent($content);
    }

    /**
     * @return StatusView
     */
    protected function getView()
    {
        if ($this->_view === null) {
            $this->_view = $this->s('view.status');
        }

        return $this->_view;
    }
}