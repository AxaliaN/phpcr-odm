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

namespace Doctrine\ODM\PHPCR\Event;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs as BaseLifecycleEventArgs;

/**
 * @deprecated Will be dropped in favor of Doctrine\Common\Persistence\Event\LifecycleEventArgs
 */
class LifecycleEventArgs extends BaseLifecycleEventArgs
{
    /**
     * @deprecated  Will be dropped in favor of getObject in 1.0
     *
     * @return      object
     */
    public function getDocument()
    {
        trigger_error('The getDocument method is deprecated, use getObject instead', E_USER_DEPRECATED);
        return $this->getObject();
    }

    /**
     * @deprecated  Will be dropped in favor of getObjectManager in 1.0
     *
     * @return      \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function getDocumentManager()
    {
        trigger_error('The getDocumentManager method is deprecated, use getObjectManager instead', E_USER_DEPRECATED);
        return $this->getObjectManager();
    }
}
