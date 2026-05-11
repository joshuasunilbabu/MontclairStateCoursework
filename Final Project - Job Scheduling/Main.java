import java.util.Scanner;
import java.util.LinkedList;

public class Main {
    public static void main(String[] args) {
        // Create necessary objects (LinkedList, Queue, Stack)
        LinkedList taskList = new LinkedList();
        Queue taskQueue = new Queue();
        Stack taskStack = new Stack(10); // Assume stack size of 10

        Scanner scanner = new Scanner(System.in);
        boolean running = true;

        while (running) {
            System.out.println("\nJob Scheduling System:");
            System.out.println("1. Add a new job");
            System.out.println("2. Modify an existing job");
            System.out.println("3. Cancel a job");
            System.out.println("4. Process jobs");
            System.out.println("5. Undo jobs");
            System.out.println("6. Exit");
            System.out.print("Enter your choice: ");
            
            int choice = -1;
            if (scanner.hasNextInt()) {
                choice = scanner.nextInt();
                scanner.nextLine(); // consume newline
            }           
              else {
                System.out.println("Invalid input. Please enter a number.");
                scanner.nextLine(); // clear bad input
                continue; // skip to next iteration

            switch (choice) {
                case 1: // Add a new job case
                    System.out.print("Enter job: ");
                    String name = scanner.nextLine();
                    System.out.print("Enter priority: ");
                    int priority = scanner.nextInt();
                    System.out.print("Enter time duration: ");
                    int duration = scanner.nextInt();
                    scanner.nextLine(); // consume newline

                    Task newTask = new Task(name, priority, duration);
                    taskList.add(newTask);
                    taskQueue.enqueue(newTask);
                    System.out.println("Job has been added.");
                    break;                    

                case 2: // Modify an existing job case
                    System.out.print("Enter job to modify: ");
                    String modName = scanner.nextLine();
                    Task modJob = findTask(taskList, modName);
                    if (modJob != null) {
                        System.out.print("Enter new priority: ");
                        modJob.setPriority(scanner.nextInt());
                        System.out.print("Enter the new duration: ");
                        modJob.setDuration(scanner.nextInt());
                        scanner.nextLine(); // consume newline
                        System.out.println("Job has been updated.");
                    } else {
                        System.out.println("Job is not found.");
                    }                   
                      break;

                case 3: // Cancel a job case
                    System.out.print("Enter job name to cancel: ");
                    String delName = scanner.nextLine();
                    Task delTask = new Task(delName, 0, 0);
                    taskList.remove(delTask);
                    System.out.println("Job removed from task list.");
                    break;                    

                case 4: // Process jobs case
                    Task processed = taskQueue.dequeue();
                    if (processed != null) {
                        System.out.println("Processing job: " + processed);
                        taskStack.push(processed);
                    }                   
                    break;

                case 5: // Undo jobs case
                    Task undo = taskStack.pop();
                    if (undo != null) {
                        System.out.println("Undoing job: " + undo);
                        taskList.add(undo);
                        taskQueue.enqueue(undo);
                    }                   
                    break;

                case 6: // Exit case
                    running = false;
                    System.out.println("Exiting the system.");
                    break;

                default:
                    System.out.println("Invalid option. Please try again.");
            }
        }
        scanner.close();
    }
  }
}
    private static Task findTask(LinkedList taskList, String name) {
         ListNode current = taskList.head; 
         while (current != null) {
         Task task = current.data;
         if (task.getName().equalsIgnoreCase(name)) {
            return task;
        }
        current = current.next;
       
        }
   }
   
   return null;
}

