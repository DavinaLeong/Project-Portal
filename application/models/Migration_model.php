<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Migration_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 26 Jan 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Migration_model extends CI_Model
{
    public function run_parsed_sql($sql)
    {
        $sql_statements = explode(';', $sql);
        $this->db->trans_start();
        $output_str = '';
        array_pop($sql_statements);
        foreach($sql_statements as $sql_statement)
        {
            try
            {
                $query = $this->db->query($sql_statement);
                if(is_object($sql_statement))
                {
                    $output_str = $output_str . "<p><strong>$sql_statement</strong></p><p><pre>" . json_encode($query->result_array(). JSON_PRETTY_PRINT) . "</pre></p>";
                }
                else
                {
                    $status = $query ? '<span style="color:green">success</span>' : '<span style="color: darkred">failure</span>';
                    $output_str = $output_str . "<p><strong>$sql_statement</strong</p><p>" . $status . "</p>";

                }
            }
            catch (Exception $e)
            {
                $output_str = $output_str . "<p><strong>$sql_statement</strong></p><p><pre>" . $e->getMessage() . "</pre></p>";
            }
        }
        $this->db->trans_complete();

        $output = array(
            'output_str' => $output_str,
            'status' => $this->db->trans_status() ? '<p style="color:green"><strong>SUCCESS</strong></p>' : '<p style="color:darkred"><strong>FAILURE</strong></p>'
        );

        return $output;
    }

	public function run_sql($sql,
                            $success_msg='<p style="color:darkred;"><strong>Success</strong></p>',
                            $error_msg='<p style="color:green;"><strong>Failure</strong></p>')
    {
        if($this->db->query($sql))
        {
            return $success_msg;
        }
        else
        {
            return $error_msg;
        }
    }

    public function reset()
    {
        $this->load->library('migration');
        $this->migration->version('20170209092304');
        $this->migration->current();
    }

    public function get_version()
    {
        $query = $this->db->get('migrations');
        return $query->row_array()['version'];
    }

} // end Migration_model class