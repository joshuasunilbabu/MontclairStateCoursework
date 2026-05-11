import java.util.ArrayList;
import java.util.List;

public class LinkedList {
    private ListNode head;

    public LinkedList() {
        head = null;
    }

    public void add(Task task) {
        ListNode newNode = new ListNode(task);
        if (head == null) {
            head = newNode;
        } else {
            ListNode current = head;
            while (current.getNext() != null) {
                current = current.getNext();
            }
            current.setNext(newNode);
        }
    }

    public void display() {
        ListNode current = head;
        while (current != null) {
            System.out.println(current.getTask());
            current = current.getNext();
        }
    }

    public void remove(Task task) {
        if (head == null) return;

        if (head.getTask().equals(task)) {
            head = head.getNext();
            return;
        }

        ListNode current = head;
        while (current.getNext() != null && !current.getNext().getTask().equals(task)) {
            current = current.getNext();
        }

        if (current.getNext() != null) {
            current.setNext(current.getNext().getNext());
        }
    }

    public List<Task> getAllTasks() {
        List<Task> tasks = new ArrayList<>();
        ListNode current = head;
        while (current != null) {
            tasks.add(current.getTask());
            current = current.getNext();
        }
        return tasks;
    }
}
