<?php namespace Fotheby\Controllers;

use Fotheby\Database\MySQLDatabaseConnection as Connection;
use Fotheby\Database\PDODatabaseStatement as Statement;

class MaintenanceCheckout extends Controller
{

  public function display($params)
  {
    $issue = $params['issue'];

    $SQL = 'SELECT * FROM VehicleReportedIssues WHERE idReportedIssues = :issue';
    $statement = new Statement(new Connection);
    $statement->setInt('issue', $issue);
    $details = $statement->select($SQL)->first();

    $data = [
      'details' => $details
    ];

    $html = $this->view->render('MaintenanceCheckOut', $data);
    $this->response->setContent($html);
  }

  public function checkout($params)
  {
    $issue = $params['issue'];
    $description = $this->request->getParameter('description');

    $connection = new Connection();

    // get the vehicle form the issue number
    $SQL = "SELECT idVehicle FROM VehicleReportedIssues WHERE idReportedIssues = :issue";
    $statement = new Statement($connection);
    $statement->setInt('issue', $issue);
    $vehicle = $statement->select($SQL)->first()['idVehicle'];

    // insert the vehicle to maintenance
    $SQL = 'INSERT INTO Maintenance (_idVehicle, BriefDescription, MaintenanceEntryDate)
            VALUES (:vehicle, :description, CURRENT_TIMESTAMP)';
    $statement = new Statement($connection);
    $statement->setInt('vehicle', $vehicle);
    $statement->setInt('description', $description);
    $log = $statement->insert($SQL);

    // update the reported issues table
    $SQL = 'UPDATE ReportedIssues SET _MaintenanceLogNumber = :log WHERE idReportedIssues = :issue';
    $statement = new Statement($connection);
    $statement->setInt('log', $log);
    $statement->setInt('issue', $issue);
    $statement->update($SQL);

    header('Location:/mechanic');
  }
}