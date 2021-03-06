<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ODM\PHPCR;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Referrer collection class
 *
 * This class represents a collection of referrers of a document which phpcr
 * names match a optional name
 *
 */
class ReferrersCollection extends PersistentCollection
{
    private $document;
    private $type;
    private $name;

    public function __construct(DocumentManager $dm, $document, $type = null, $name = null, $locale = null)
    {
        $this->dm = $dm;
        $this->document = $document;
        $this->type = $type;
        $this->name = $name;
        $this->locale = $locale;
    }

    /**
     * Initializes the collection by loading its contents from the database
     * if the collection is not yet initialized.
     */
    public function initialize()
    {
        if (!$this->initialized) {
            $uow = $this->dm->getUnitOfWork();
            $node = $this->dm->getPhpcrSession()->getNode($uow->getDocumentId($this->document));

            $referrerDocuments = array();
            $referrerPropertiesW = array();
            $referrerPropertiesH = array();

            switch ($this->type) {
                case 'weak':
                    $referrerPropertiesW = $node->getWeakReferences($this->name);
                    break;
                case 'hard':
                    $referrerPropertiesH = $node->getReferences($this->name);
                    break;
                default:
                    $referrerPropertiesW = $node->getWeakReferences($this->name);
                    $referrerPropertiesH = $node->getReferences($this->name);
            }

            $locale = $this->locale ?: $uow->getCurrentLocale($this->document);

            foreach ($referrerPropertiesW as $referrerProperty) {
                $referrerNode = $referrerProperty->getParent();
                $referrerDocuments[] = $uow->getOrCreateProxyFromNode($referrerNode, $locale);
            }

            foreach ($referrerPropertiesH as $referrerProperty) {
                $referrerNode = $referrerProperty->getParent();
                $referrerDocuments[] = $uow->getOrCreateProxyFromNode($referrerNode, $locale);
            }

            $this->collection = new ArrayCollection($referrerDocuments);
            $this->initialized = true;
        }
    }
}
