<?php 

namespace App\Service;


use App\Entity\Organization;
use Symfony\Component\Yaml\Exception\DumpException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class OrgManager {

    const PATH = '../data/organizations.yaml';

	public function __construct() {

	}

    public function getOrganizations() {
        try {
            return Yaml::parse(file_get_contents(self::PATH))['organizations'];
        }
        catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    /**
     * @param int $index
     * @return mixed|void
     */
    public function getOrganization(int $index) {
        try {
            return Yaml::parse(file_get_contents(self::PATH))['organizations'][$index];
        }
        catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    public function add(Organization $organization) {
        try {
            $data = Yaml::parse(file_get_contents(self::PATH));
            $organizations = $data['organizations'];
            $organizations[] = $organization->__toArray();
            $data['organizations'] = $organizations;

            try {
                $yaml = Yaml::dump($data, 5, 2);
                file_put_contents(self::PATH, $yaml);
            }
            catch (DumpException $exception) {
                printf('Unable to dump the YAML string: %s', $exception->getMessage());
            }
        }
        catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    public function update(array $organization, int $index) {
        try {
            $data = Yaml::parse(file_get_contents(self::PATH));
            $organizations = $data['organizations'];
            $organizations[$index] = $organization;
            $data['organizations'] = $organizations;

            try {
                $yaml = Yaml::dump($data, 5, 2);
                file_put_contents(self::PATH, $yaml);
            }
            catch (DumpException $exception) {
                printf('Unable to dump the YAML string: %s', $exception->getMessage());
            }
        }
        catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    public function delete(int $index) {
        try {
            $data = Yaml::parse(file_get_contents(self::PATH));
            $organizations = $data['organizations'];
            array_splice($organizations, $index, 1);
            $data['organizations'] = $organizations;

            try {
                $yaml = Yaml::dump($data, 5, 2);
                file_put_contents(self::PATH, $yaml);
            }
            catch (DumpException $exception) {
                printf('Unable to dump the YAML string: %s', $exception->getMessage());
            }
        }
        catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }
}