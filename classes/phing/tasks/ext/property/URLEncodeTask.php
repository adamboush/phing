<?php
/**
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
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

/**
 * @author    Siad Ardroumli <siad.ardroumli@gmail.com>
 * @package   phing.tasks.ext.property
 */
class URLEncodeTask extends AbstractPropertySetterTask
{
    /**
     * @var string
     */
    private $value = '';

    /**
     * @var Reference
     */
    private $ref;

    public function setValue(string $value)
    {
        $this->value = urlencode($value);
    }

    public function getValue(Project $p): string
    {
        if ($this->ref !== null) {
            $this->setValue($this->ref->getReferencedObject($p));
        }

        return $this->value;
    }

    public function setRefid(Reference $ref)
    {
        $this->ref = $ref;
    }

    public function __toString()
    {
        return $this->value;
    }

    protected function validate()
    {
        parent::validate();
        if ($this->value === null && $this->ref === null) {
            throw new BuildException(
                'You must specify value or refid with the name attribute',
                $this->getLocation()
            );
        }
    }

    public function main()
    {
        parent::validate();
        $val = $this->getValue($this->getProject());
        $this->setPropertyValue($val);
    }
}
