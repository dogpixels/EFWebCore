using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Inventory : MonoBehaviour
{
    public static Inventory instance;

    public List<Item> items = new List<Item>();

    public int space;

    #region singleton
    private void Awake()
    {
        if (instance != null)
        {
            Debug.Log("Warning more than one Instance of Inventory found!");
        }
        instance = this;
    }

    private void Start()
    {
        EquipmentManager.instance.onEquipmentChanged += OnEquipmentChanged;
    }

    private void OnEquipmentChanged(Equipment newItem, Equipment oldItem)
    {
        //Debug.Log($"Inventory.OnEquipmentChange() called. newItem: {newItem}, oldItem: {oldItem}.");
        if (oldItem != null)
            space -= oldItem.backpackplus; // remove old item modifier

        if (newItem != null)
            space += newItem.backpackplus; // add new item modifier

        Debug.Log($"New inventory space: {space}");
    }

    #endregion

    public delegate void OnItemChanged();
    public OnItemChanged onItemChangedCallback;


 
    public bool Add(Item item)
    {
        if (!item.isDefaultItem)
        { 
            if (items.Count >=space)
            {
                Debug.Log("Not enough room." + items.Count);
                return false;
            }
            items.Add(item);

            if (onItemChangedCallback != null)
            onItemChangedCallback.Invoke();
        }
        return true;
    }

    /// <summary>
    /// Removes an item from inventory (list and visually).
    /// </summary>
    /// <param name="item">The item object to be removed.</param>
    public void Remove(Item item)
    {
        items.Remove(item);
      
        if (onItemChangedCallback != null)
        {
              onItemChangedCallback.Invoke();
        }
    }
}